@api
@api_account
@api_account_confirm_registration

Feature: As an anonymous user, I need to be able to activate my account

  Background:
    Given I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |

  Scenario: [Fail] Submit request with no token and no email
    When I send a "POST" request to "/api/accounts/confirm" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "email": [
            "Une adresse email est requise."
        ],
        "token": [
            "Identifiant unique non trouvé."
        ]
    }
    """

  Scenario: [Fail] Submit request with invalid token
    When I send a "POST" request to "/api/accounts/confirm?tokenActivation=AmazingToken" with body:
    """
    {
        "email": "johndoe@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "token": [
            "L'identifiant unique fourni est incorrect."
        ]
    }
    """

  Scenario: [Fail] Submit request with good token but invalid email
    When I send a "POST" request to "/api/accounts/confirm?tokenActivation=SomeToken" with body:
    """
    {
        "email": "janedoe@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "email": [
            "Merci de vérifier l'adresse email avec laquelle vous vous êtes inscrit dans votre boite mail."
        ]
    }
    """

  Scenario: [Success] Submit request with good token and good email
    When I send a "POST" request to "/api/accounts/confirm?tokenActivation=SomeToken" with body:
    """
    {
        "email": "johndoe@yopmail.com"
    }
    """
    Then the response status code should be 200
    And user "johndoe" should have status "activated"
    And the JSON should be valid according to this schema:
    """
    {
        "type": "object",
        "properties": {
            "token": {
                "type": "string",
                "required": true
            },
            "user": {
                "type": "object",
                "properties": {
                    "firstname": {
                        "type": "string",
                        "required": true
                    },
                    "lastname": {
                        "type": "string",
                        "required": true
                    },
                    "username": {
                        "type": "string",
                        "required": true
                    },
                    "email": {
                        "type": "string",
                        "required": true
                    },
                    "roles": {
                        "type": "array",
                        "items": {
                            "type": "string"
                        }
                    }
                }
            }
        }

    }
    """
