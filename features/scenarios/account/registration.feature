@api
@api_account
@api_account_registration

Feature: As an anonymous user, I need to be able to submit registration request

  Background:
    Given I load following users:
    | firstname | lastname | username | password | email               | tokenActivation |
    | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"

  Scenario: [Fail] Submit request with user authenticated
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "POST" request to "/api/accounts" with body:
    """
    {
        "firstname": "Jane",
        "lastname": "Doe",
        "username": "janedoe",
        "password": "12345678",
        "email": "janedoe@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "message": "Vous ne pouvez pas vous inscrire en étant déjà connecté."
    }
    """

  Scenario: [Fail] Submit request with invalid payload. Fields must be present
    When I send a "POST" request to "/api/accounts" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "firstname": [
            "Le prénom est obligatoire."
        ],
        "lastname": [
            "Le nom est obligatoire."
        ],
        "username": [
            "Le nom d'utilisateur est obligatoire."
        ],
        "password": [
            "Le mot de passe est obligatoire."
        ],
        "email": [
            "L'adresse email est obligatoire."
        ]
    }
    """

  Scenario: [Fail] Submit request with already exist username. Fields must be present
    When I send a "POST" request to "/api/accounts" with body:
    """
    {
        "firstname": "John",
        "lastname": "Doe",
        "username": "johndoe",
        "password": "12345678",
        "email": "janedoe@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "": [
            "Cet utilisateur est déjà existant."
        ]
    }
    """

  Scenario: [Fail] Submit request with already exist email. Fields must be present
    When I send a "POST" request to "/api/accounts" with body:
    """
    {
        "firstname": "John",
        "lastname": "Doe",
        "username": "janedoe",
        "password": "12345678",
        "email": "johndoe@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "": [
            "Cet utilisateur est déjà existant."
        ]
    }
    """

  Scenario: [Success] Submit request with valid datas
    When I send a "POST" request to "/api/accounts" with body:
    """
    {
        "firstname": "Jane",
        "lastname": "Doe",
        "username": "janedoe",
        "password": "12345678",
        "email": "janedoe@yopmail.com"
    }
    """
    Then the response status code should be 201
    And the response should be empty
