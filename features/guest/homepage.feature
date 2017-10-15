@static
Feature: Homepage
    In order to learn about OurSociety
    As a visitor
    I need to be able to view the homepage

    Scenario: Introduction on landing page
        Given I am on "/"
        Then I should see "OurSociety"
        And I should see "Reimagining Democracy"
        And I should see "Expanding Possibilities"
        And I should see "Creating Collaboration"

    Scenario: Wireframe on home page
        Given I am on "/home"
        Then I should see "OurSociety"
        And I should see "Grassroots - Transparent - Issue Focused"
        And I should see "Changing the way we campaign and vote one question at a time"
        And I should see "Login"
        And I should see "Register"
