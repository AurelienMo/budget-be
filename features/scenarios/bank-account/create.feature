@api
@api_bank_account
@api_bank_account_create

Feature: As an auth user, I need to be able to create bank account

  Background:
    Given I load production file
    And I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"

  Scenario: [Fail] Submit request with an anonymous user
    When I send a "GET" request to "/api/banks"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Fail] Submit request with not required fields
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "POST" request to "/api/bank-accounts" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the response should be equal to following file "bank-account/output/errors_not_blank.json"

  Scenario: [Fail] Submit request with invalid bank
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "POST" request to "/api/bank-accounts" with body:
    """
    {
        "cfgBank": "Amazing Bank",
        "name": "Johndoe Amazing Bank",
        "initialBalance": 10000
    }
    """
    Then the response status code should be 400
    And the response should be equal to following file "bank-account/output/invalid_bank.json"

  Scenario: [Success] Submit valid request to create bank account
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "POST" request to "/api/bank-accounts" with body:
    """
    {
        "cfgBank": "boursorama",
        "name": "Johndoe Amazing Bank",
        "initialBalance": 10000
    }
    """
    Then the response status code should be 201
    And user "johndoe" should have a bank account with name "Johndoe Amazing Bank"
    And balance for account "Johndoe Amazing Bank" for user "johndoe" should be equal to "10000"
