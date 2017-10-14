@admin
Feature: Admin can manage users
    In order to be in control
    As an admin
    I need to be able to manage users

    Background:
        Given the following users:
        | Name                | Role       |
        | OurSociety Team     | admin      |
        | John Doe            | politician |
        | Imported Politician | politician |
        | Citizen 1           | citizen    |
        | Citizen 2           | citizen    |
        | Citizen 3           | citizen    |

    Scenario: List users
        Given I am logged in as an admin
        When I visit the user list page
        Then I should see the following records listed:
            | Full Name             | Role       |
            | Citizen 2             | citizen    |
            | Citizen 3             | citizen    |
            | Imported Politician   | politician |
            | John Doe              | politician |
            | OurSociety Team       | admin      |
            | Community Contributor | citizen    |
            | Ron Rivers            | citizen    |

    Scenario: Delete user
        Given I am logged in as an admin
        When I delete "Citizen 3"
        Then I should see a success message that says "User deleted"
        And I should see the following records listed:
            | Name                | Role       |
            | Citizen 1           | citizen    |
            | Citizen 2           | citizen    |
            | Imported Politician | politician |
            | John Doe            | politician |
            | OurSociety Team     | admin      |
#
#    Scenario: Delete myself
#        Given the following users:
#            | Name                | Role       |
#            | Citizen 1           | citizen    |
#            | Citizen 2           | citizen    |
#            | Citizen 3           | citizen    |
#            | Imported Politician | politician |
#            | John Doe            | politician |
#            | OurSociety Team     | admin      |
#        And I am logged in as an admin
#        When I try to delete OurSociety Team
#        Then I should get an error

#        Given I logged in as an admin
#        And
#        Then I should see "OurSociety"
#        And I should see "Reimagining Democracy"
#        And I should see "Expanding Possibilities"
#        And I should see "Creating Collaboration"
