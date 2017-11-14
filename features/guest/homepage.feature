@static
Feature: Homepage
  In order to use OurSociety
  As a visitor
  The homepage should do something

  Scenario: Homepage redirects to sign in screen
    Given I am on the homepage
    Then I should be on the login page

#    Scenario: Introduction on landing page
#        Given I am on "/"
#        Then I should see "OurSociety"
#        And I should see "Reimagining Democracy"
#        And I should see "Expanding Possibilities"
#        And I should see "Creating Collaboration"
#
#    Scenario: Wireframe on home page
#        Given I am on "/home"
#        Then I should see "OurSociety"
#        And I should see "Grassroots - Transparent - Issue Focused"
#        And I should see "Changing the way we campaign and vote one question at a time"
#        And I should see "Login"
#        And I should see "Register"
