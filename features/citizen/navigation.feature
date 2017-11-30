Feature: Navigation
  In order to navigate the application
  As a citizen
  The navigation should make sense

  Scenario: Logo in top navigation links to dashboard
    Given I am signed in as "Onboarded citizen"
    And I am on the citizen dashboard page
    When I click the logo in the top navigation
    Then I should be on the citizen dashboard page
