@admin
Feature: Admins can impersonate other users
  In order to administrate the platform
  As an admin
  I need to be able to impersonate other users

  Scenario: Impersonate users
    Given I am logged in as "OurSociety Team"
    When I impersonate "Onboarded Citizen"
    Then I should be logged in as "Onboarded Citizen"
    And I should be on the citizen dashboard page
