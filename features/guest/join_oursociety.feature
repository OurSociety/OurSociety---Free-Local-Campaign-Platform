@user
Feature: Guests can join OurSociety
  In order to use the application
  As a guest
  I want to be able to join OurSociety

  Scenario: Guests can join OurSociety
    When I sign up with name "Guest", email "guest@example.com" and password "democracy"
    Then I should be on the onboarding page
    And I should see the success message "Welcome to OurSociety!"

  Scenario: Passwords must not be too short
    When I sign up with name "Guest", email "guest@example.com" and password "hi"
    Then I should be on the sign up page
    And I should see the error message "Sorry, that password is too short."
