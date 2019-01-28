@api
@api_account
@api_account_define_new_password

Feature: As an anonymous user, I need to be able to send a reset password request
  Background:
    Given I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"
    And I reinit password for user "johndoe" with token "ASomeToken"

  Scenario: [Fail] Submit request with no payload and no token
    When I send a "POST" request to "/api/accounts/define-new-password" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "token": [
            "L'identifiant unique est requis."
        ],
        "email": [
            "L'adresse email est requise."
        ],
        "password": [
            "Le mot de passe est requis."
        ]
    }
    """

  Scenario: [Fail] Submit request with invalid email and valid token
    When I send a "POST" request to "/api/accounts/define-new-password?tokenResetPassword=ASomeToken" with body:
    """
    {
        "email": "janedoe@yopmail.com",
        "password": "123456789"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "": [
            "L'adresse email est invalide."
        ]
    }
    """

  Scenario: [Fail] Submit request with valid email but invalid token
    When I send a "POST" request to "/api/accounts/define-new-password?tokenResetPassword=SomeToken" with body:
    """
    {
        "email": "johndoe@yopmail.com",
        "password": "123456789"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "": [
            "L'identifiant unique fourni est invalide."
        ]
    }
    """
  Scenario: [Success] Submit request with datas
    When I send a "POST" request to "/api/accounts/define-new-password?tokenResetPassword=ASomeToken" with body:
    """
    {
        "email": "johndoe@yopmail.com",
        "password": "123456789"
    }
    """
    Then the response status code should be 200
    And user "johndoe" should have status "activated"
    And the JSON node "token" should exist
    And the JSON node "user.firstname" should be equal to "John"
    And the JSON node "user.lastname" should be equal to "Doe"
    And the JSON node "user.username" should be equal to "johndoe"
    And the JSON node "user.email" should be equal to "johndoe@yopmail.com"
    And the JSON node "user.roles[0]" should be equal to "ROLE_USER"
