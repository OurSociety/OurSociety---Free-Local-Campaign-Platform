@user
Feature: Users can log in
  In order to use the application
  As a visitor
  I want to be able to log in

  Scenario: Visitors can reach login page
    Given I am on "/home"
    When I follow "Sign In"
    Then I should see "Email Address"
    And I should see "Password"
    And I should see "Remember me"
    And I should see "Join OurSociety"
    And I should see "Forgot password?"
    And I should see "Sign In"

  Scenario: An error is displayed if email is not recognized
    Given I am on "/login"
    When I fill in "Email" with "unknown@example.net"
    And I fill in "Password" with "anything"
    And I press "Sign In"
    Then I should be on "/login"
    And I should see "Sorry, that email and password combination was not recognized."

  Scenario: An error is displayed if password is incorrect
    Given I am on "/login"
    When I fill in "Email" with "citizen@example.net"
    And I fill in "Password" with "incorrect"
    And I press "Sign In"
    Then I should be on "/login"
    And I should see "Sorry, that email and password combination was not recognized."

  Scenario: Citizens can log in
    Given I am on "/login"
    When I fill in "Email" with "citizen@example.net"
    And I fill in "Password" with "democracy"
    And I press "Sign In"
    Then I should see "Welcome to OurSociety!"
    And I should see "Citizen 1"
    And I should see "Sign Out"

  Scenario: Citizens can log in
    Given I am on "/login"
    When I fill in "Email" with "citizen@example.net"
    And I fill in "Password" with "democracy"
    And I press "Sign In"
    Then I should be on "/citizen"
    And I should see "Welcome to OurSociety!"
    And I should see "Citizen 1"
    And I should see "Sign Out"

  Scenario: Politicians can log in
    Given I am on "/login"
    When I fill in "Email" with "politician@example.org"
    And I fill in "Password" with "democracy"
    And I press "Sign In"
    Then I should be on "/politician"
    And I should see "Welcome to OurSociety!"
    And I should see "John Doe"
    And I should see "Sign Out"

#  Scenario: Administrators can log in
#    Given I am on "/login"
#    When I fill in "Email" with "team@oursociety.org"
#    And I fill in "Password" with "democracy"
#    And I press "Sign In"
#    Then I should see "Dashboard Overview"
#    And I should see "Go to Website"
