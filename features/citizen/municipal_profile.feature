Feature: Public municipal profile
  In order to contribute to my municipality profile
  As a community contributor
  I want to submit an article for fact-checking

  Scenario: Citizen can see button to submit articles on their selected municipality
    Given I am signed in as "Onboarded Citizen"
    And my selected municipality is "Example City"
    When I am on the "Example City" municipal profile
    Then I should see the "Submit Your Own Idea" button

  Scenario: Citizen can submit article for fact-checking on their selected municipality
    Given I am signed in as "Onboarded Citizen"
    And I have no unread notifications
    When I am on the "Example City" municipal profile
    And I follow "Submit Your Own Idea"
    And I fill in "Article Title" with "Hero of Local Community"
#    And I select "Vision" from "Article Type"
#    And I select "Housing / Community" from "Societal Aspect"
#    And I fill in "Article Body" with "Lorem ipsum."
    And I select "Vision" from "article_type"
    And I select "Housing / Community" from "aspect"
    And I fill in "body" with "Lorem ipsum."
    And I press the "Submit Article for Fact-Checking" button
    Then I should be on the "Example City" municipal profile
    And I should see the success message:
      """
      Thanks for submitting! This article is now in the queue for fact-­checking and will be approved soon.
      """
    And I should have 1 unread notifications
    And the most recent notification should have the title:
      """
      Article "Hero of Local Community" undergoing fact-checking
      """

# TODO: Old notes - remove when above tests fully implemented and tests for approval/listing are implemented
#  Scenario: Citizen can submit article for fact-checking
#    Given I am on "/citizen/profile" (?)
#    And I click "Post an article" (?)
#    And I fill in "Article Title" with "Hero of Local Community"
#    And I select "Vision" from the "Article Type" dropdown
#    And I select "Housing / Community" from the "Societal Aspect" dropdown
#    And I enter article text into the "Article Body" field
#    And I see the button "Save as draft"
#    And I press the button "Submit for approval"
#    Then my article is approved
#    And I follow link to "My Virtual Town Hall" (?)
#    And I see my article "Hero of Local Community" as the first vision under latest articles
