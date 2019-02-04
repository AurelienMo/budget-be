@api
@api_bank_account
@api_bank_account_detail

Feature: As an auth user, I need to be able to show detail account

  Background:
    Given I load production file
    And I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
      | Jane      | Doe      | janedoe  | 12345678 | janedoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"
    And I enable user "janedoe"

  Scenario: [Fail] Submit request with anonymous user
    When I send a "GET" request to "/api/bank-accounts"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Fail] Submit request with user has no access to this bank account
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA"
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAB" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Ce compte n'existe pas."

  Scenario: [Fail] Submit request with user has no access to this bank account
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA"
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous n'avez pas les droits pour accéder à ce compte."

  Scenario: [Fail] Submit request with user in group but account is not visible
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA"
    And user "johndoe" should created following group:
    | name     |
    | DoeGroup |
    And users have following group:
    | username | slugGroup |
    | janedoe  | doegroup |
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Le compte de la personne de ce groupe n'est pas partagé."

  Scenario: [Success] Submit request and obtain detail bank account informations
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And following operations manual has been added to account with name "JDoe Boursorama":
      | cfgTypeOperation | cfgCategoryOperation | beneficiary    | amount  | dateOperation |
      | carte-bleue      | loisirs              | McDo           | -38.00  | 01/02/2019    |
      | carte-bleue      | loisirs              | McDo           | -50.00  | 01/02/2019    |
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    """
    Then the response status code should be 200
    And the JSON node "account.name" should be equal to "JDoe Boursorama"
    And the JSON node "account.id" should be equal to "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And the JSON node "account.balance" should be equal to "912"
    And the JSON node "account.displayInGroup" should be false
    And the JSON node "account.cfgBank.name" should be equal to "Boursorama"
    And the JSON node "operationsManual" should have 2 elements
