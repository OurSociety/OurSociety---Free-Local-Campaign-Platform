@user
Feature: Users can log in
    In order to use the application
    As a visitor
    I want to be able to log in

    Scenario: Visitors can reach login page
        Given I am on "/home"
        When I follow "Login"
        Then I should see "Please enter your email and password"
        And I should see "Email"
        And I should see "Password"
        And I should see "Remember me"
        And I should see "Register"
        And I should see "Forgot Password"
        And I should see "Login"
        #Then I take a screenshot

    Scenario: Citizens can log in
        Given I am on "/login"
        When I fill in "Email" with "citizen@example.net"
        And I fill in "Password" with "democracy"
        And I press "Login"
        Then I should see "Welcome to OurSociety!"
        And I should see "Citizen 1"
        And I should see "Logout"

    Scenario: Politicians can log in
        Given I am on "/login"
        When I fill in "Email" with "politician@example.org"
        And I fill in "Password" with "democracy"
        And I press "Login"
        Then I should see "Welcome to OurSociety!"
        And I should see "John Doe"
        And I should see "Logout"

    Scenario: Administrators can log in
        Given I am on "/login"
        When I fill in "Email" with "team@oursociety.org"
        And I fill in "Password" with "democracy"
        And I press "Login"
        Then I should see "Dashboard Overview"
        And I should see "Go to Website"
