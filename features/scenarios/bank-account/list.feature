@api
@api_bank_account
@api_bank_account_list

Feature: As an auth user, I need to be able to list bank accounts

  Background:
    Given I load production file
    And I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"

  Scenario: [Fail] Submit request with anonymous user
    When I send a "GET" request to "/api/banks"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Success] Submit request and return no datas
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/bank-accounts" with body:
    """
    """
    Then the response status code should be 204
    And the response should be empty

  Scenario: [Success] Obtain bank accounts informations
    And users has following bank accounts:
      | user    | name            | bank             | initialBalance |
      | johndoe | JDoe Boursorama | boursorama       | 1000           |
      | johndoe | JDoe Societe    | societe-generale | 282            |
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/bank-accounts" with body:
    """
    """
    Then the response status code should be 200
    And the JSON node "root" should have 2 elements
