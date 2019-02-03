@api
@api_bank
@api_bank_list

Feature: As an authenticated user, I need to be able to get list bank

  Background:
    Given I load production file
    And I load following users:
      | firstname | lastname | username | password | email               | tokenActivation |
      | John      | Doe      | johndoe  | 12345678 | johndoe@yopmail.com | SomeToken       |
    And I enable user "johndoe"

  Scenario: [Fail] Submit request with a anonymous user
    When I send a "GET" request to "/api/banks"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Success] Submit request and obtain no result
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/banks?search=AmazingBank" with body:
    """
    """
    Then the response status code should be 204
    And the response should be empty

  Scenario: [Success] Submit request and obtain filtered result
    When I send a "GET" request to "/api/banks?search=Bours"
    Then the response status code should be 200
    And the JSON node "root" should have "1" element
    And the JSON node "root[Ø].name" should be equal to "Boursorama"
    And the JSON node "root[Ø].slug" should be equal to "boursorama"
