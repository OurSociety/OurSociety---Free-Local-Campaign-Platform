Feature: Citizens onboarding
  In order to be inducted to the platform
  As a citizen
  I need to be able to go through the onboarding process

  Scenario: New citizens must go through the tutorial process
    Given I am signed in as "New Citizen"
    And I am on the "Onboarding" page
    When I click through the tutorial screens
    And I set my location to "Example City"
    And I go to the "My Municipality" page
    Then I should be on the "Example City" municipality
