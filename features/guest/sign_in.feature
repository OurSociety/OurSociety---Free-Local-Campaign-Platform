@user
Feature: Guests can sign in
  In order to use the application
  As the guest
  I want to be able to sign in

  Scenario: New citizens must go through the onboarding process
    Given I am on the sign in page
    When I sign in with email "new-citizen@example.com" and password "democracy"
    Then I should see the success message "Welcome to OurSociety!"
    And I should be on the onboarding page

  Scenario: Onboarded citizens can sign in directly to citizen dashboard
    Given I am on the sign in page
    When I sign in with email "onboarded-citizen@example.com" and password "democracy"
    Then I should see the success message "Welcome to OurSociety!"
    And I should be on the citizen dashboard

  Scenario: Politicians can sign in to politician dashboard
    Given I am on the sign in page
    When I sign in with email "politician@example.com" and password "democracy"
    Then I should see the success message "Welcome to OurSociety!"
    And I should be on the politician dashboard

  Scenario: Admins can sign in to admin dashboard
    Given I am on the sign in page
    When I sign in with email "team@oursociety.org" and password "democracy"
    Then I should see the success message "Welcome to OurSociety!"
    And I should be on the admin dashboard

  Scenario: An error is displayed if the email address is not recognized
    Given I am on the sign in page
    When I sign in with email "unknown-user@example.com" and password "anything"
    Then I should see the error message "Sorry, that email and password combination was not recognized."
    And I should be on the sign in page

  Scenario: An error is displayed if the password is incorrect
    Given I am on the sign in page
    When I sign in with email "onboarded-citizen@example.com" and password "incorrect"
    Then I should see the error message "Sorry, that email and password combination was not recognized."
    And I should be on the sign in page

  Scenario: Guests can choose for system to keep them signed in
    Given I am on the sign in page
    And I leave keep me signed in checked
    And I sign in with email "onboarded-citizen@example.com" and password "democracy"
    And my browser sets a remember me cookie
    When my session expires
    And I visit the citizen dashboard
    Then I should see the info message "Welcome back, Onboarded Citizen!"
    And I should be on the citizen dashboard

  Scenario: Guests can disable system from keeping them signed in
    Given I am on the sign in page
    And I uncheck keep me signed in
    And I sign in with email "onboarded-citizen@example.com" and password "democracy"
    When my session expires
    And I try to access the citizen dashboard page
    Then I should be on the sign in page

  Scenario: Guests can access join OurSociety page from sign in page
    Given I am on the sign in page
    When I click to join OurSociety
    Then I am on the join page

  Scenario: Guests can access forgot password page from sign in page
    Given I am on the sign in page
    When I click forgot password
    Then I am on the forgot password page

  Scenario: Guests are redirected to the page they tried to access before logging in
    Given I try to access the my account page
    And I am on the sign in page
    When I sign in with email "onboarded-citizen@example.com" and password "democracy"
    Then I am on the my account page
