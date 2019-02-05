@api
@api_operation
@api_operation_list

Feature: As an auth user, I need to be able to obtain operations list

  Background:
    Given I load production file
    And I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
      | Jane      | Doe      | janedoe  | 12345678 | janedoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"
    And I enable user "janedoe"

  Scenario: [Fail] Submit request with anonymous user
    When I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/operations"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Fail] Submit request with user has no access to this bank account
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaab/operations" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Ce compte n'existe pas."

  Scenario: [Fail] Submit request with user has no access to this bank account
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/operations" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous n'avez pas les droits pour accéder à ce compte."

  Scenario: [Fail] Submit request with user in group but account is not visible
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And user "johndoe" should created following group:
      | name     |
      | DoeGroup |
    And users have following group:
      | username | slugGroup |
      | janedoe  | doegroup |
    When After authentication on url "/api/login_check" with method "POST" as user "janedoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/operations" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Le compte de la personne de ce groupe n'est pas partagé."

  Scenario: [Fail] Submit request with invalid request
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
    And account with name "JDoe Boursorama" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/bank-accounts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/operations" with body:
    """
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "offset": [
            "Ce champ est obligatoire."
        ],
        "limit": [
            "Ce champ est obligatoire."
        ]
    }
    """
