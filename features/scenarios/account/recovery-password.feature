@api
@api_account
@api_account_recovery_password

Feature: As an anonymous user, I need to be able to send a recovery password request
  Background:
    Given I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"

  Scenario: [Fail] Submit request with no payload
    When I send a "POST" request to "/api/accounts/recovery-password" with body:
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
        ]
    }
    """

  Scenario: [Success] Submit request with not found email
    When I send a "POST" request to "/api/accounts/recovery-password" with body:
    """
    {
        "email": "janedoe@yopmail.com"
    }
    """
    Then the response status code should be 201
    And 0 mails should have been sent

  Scenario: [Success] Submit request with valid email
    When I send a "POST" request to "/api/accounts/recovery-password" with body:
    """
    {
        "email": "johndoe@yopmail.com"
    }
    """
    Then the response status code should be 201
    And user "johndoe" should have a tokenResetPassword
    And user "johndoe" should have status "locked"
    And 1 mails should have been sent
    And a mail should have been sent to "johndoe@yopmail.com" with subject "[Budget Application] Demande de réinitialisation de mot de passe"
