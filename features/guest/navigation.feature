Feature: Navigation
  In order to navigate the application
  As a guest
  The navigation should make sense

  Scenario: Logo in top navigation links to root page
    When I click the logo in the top navigation
    Then I should be on the root page

  Scenario: Home link in top navigation links to blog
    Given I am on the root page
    When I click "Home" in the top navigation
    Then I should be redirected to the blog
