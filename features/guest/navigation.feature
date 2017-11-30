Feature: Navigation
  In order to navigate the application
  As a guest
  The navigation should make sense

  Scenario: Root page should be the join page
    When I am on the root page
    Then I should be on the join page

  Scenario: Logo in top navigation links to join page
    Given I am on the root page
    When I click the logo in the top navigation
    Then I should be on the join page

  Scenario: Home link in top navigation links to blog
    Given I am on the root page
    When I click "Home" in the top navigation
    Then I should be redirected to the blog
