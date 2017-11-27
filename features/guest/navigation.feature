Feature: Navigation
  In order to navigate the application
  As a guest
  The navigation should make sense

  Scenario: Logo in top navigation links to sign in page
    When I click the logo in the top navigation
    Then I should be on the sign in page

  Scenario: Home link in top navigation links to blog
    When I click "Home" in the top navigation
    Then I should be redirected to the blog
