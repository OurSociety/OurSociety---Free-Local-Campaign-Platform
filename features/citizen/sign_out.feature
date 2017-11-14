@user
Feature: Citizens can sign out
  In order to keep my account secure
  As a citizen
  I want to be able to sign out

  Scenario: Citizens can sign out from dashboard
    Given I am signed in as "Onboarded Citizen"
    When I sign out
    Then I should be on the sign in page
    And I should see the message "You have been signed out."
