Feature: Politician Awards
  In order to demonstrate my achievements
  As a politician
  I want to add awards I've received to my profile

  Background:
    Given a representative named "John Doe"
    And an award named "Best Upcoming Representative" assigned to "John Doe"

  Scenario: Awards appear on representatives public profile
    Given I am on the representative profile for "John Doe"
    Then I should see the award "Best Upcoming Representative"

  Scenario: Awards appear on representatives own profile
    Given I am signed in as "John Doe"
    And I am on my profile
    Then I should see the award "Best Upcoming Representative"

  Scenario: Representative can list awards
    Given I am signed in as "John Doe"
    And I am on my profile
    And I follow "Edit Awards"
    Then I should see a listing containing the following records:
      | Award Title                  | Obtained |
      | Best Upcoming Representative | Jul 2016 |

  Scenario: Representative can edit awards
    Given I am signed in as "John Doe"
    And I am on my profile
    And I follow "Edit Awards"
    When I click the "Edit" button on the "Best Upcoming Representative" record
    And I fill in the following:
      | Award Title          | Test Upcoming Representative |
      | Description of Award | Test Description             |
      | Date Obtained        | 2017-08                      |
    And I press "Submit"
    Then I should see the success message "The award has been saved."
    And I should be on the Award List page
    And I should see a listing containing the following records:
      | Award Title                  | Description of Award | Date Obtained |
      | Test Upcoming Representative | Test Description     | Aug 2017      |
