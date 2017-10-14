@user
Feature: Public municipal profile
  In order to learn about my local community
  As a visitor
  I want to see my municipality

  Scenario: Visitors can view aggregate content for a jurisdiction
    When I am on the "Example City" municipal profile
    Then I should see the heading "Example City"
    And I should see the mayor "Example Mayor" with the email "mayor@example.com"
    And I should see town information containing "Example City was named after the fact that it is an example."
    And I should see a map
    And I should see the following statistics:
      | Statistic                    | Count |
      | Number of Citizens           | 4     |
      | Number of Politicians        | 2     |
      | Articles being fact-checked  | 1     |
      | Number of Articles This Year | 5     |
    And I should see the following articles:
      | Title           | Type | Body                        | Read time |
      | Example Article | Plan | This is an example article. | 4 min     |
    And I should see a "Submit Your Own Idea" button that links to "/municipality/example-city/article/new"
    And I should see a "View All" button that links to "/municipality/example-city/articles"

    And I should see a "View All" button that links to "/municipality/example-city/events"

#    And I can see elected officials
#    Given I am on “/nj/municipality/west-ocean”
#    Then I can see the heading “West Ocean”
#    And I can see the mayor
#    And I can see town information
#    And I can see the first {number} elected officials in this area
#    And How do we sort these?
#    And How many per page?
#    And I can click on an elected official to see their politician profile
#    And I can (click/scroll/view a list)? to see the next page of elected officials
#    And I can see latest articles broken down by type (P/P/V)
#    And How many articles of each type?
#    And I can see a list of future events sorted by most imminent
#    And How many to show?
#    And I can click “See all events”
#    And I can see {number} community contributors
#    And How many to show?
#    And I can click on a community contributor to see their user profile
#    And I can (click/scroll/view a list)? to see the next page of community contributors
#    And (CB: This whole scenario could be split into multiple smaller scenarios)
#
#  Scenario: Citizens can create a community contributor profile
#    Given I am on “/citizen/dashboard” (?)
#    And I see an opportunity to create content
#    And I click the link and it takes me to profile I can fill in (similar to politician?)
#    And I can opt-in and create a profile (for approval) or dismiss and back to dashboard.
#
#  Scenario: Pathway politicians can create content
#    Given I am on “/citizen/profile” (?)
#    And I click “Post an article” (?)
#    And I fill in “Article Title” with “Hero of Local Community”
#    And I select “Vision” from the “Article Type” dropdown
#    And I select “Housing / Community” from the “Societal Aspect” dropdown
#    And I enter article text into the “Article Body” field
#    And I see the button “Save as draft”
#    And I press the button “Submit for approval”
#    Then my article is approved
#    And I follow link to “My Virtual Town Hall” (?)
#    And I see my article “Hero of Local Community” as the first vision under latest articles
#
#  Scenario: Municipality members can add content
#    Given I am logged in as “Mac Womack” (current elected mayor)
#    And I am on “/nj/municipality/west-ocean” (my jurisdiction)
#    And I follow the link to “Add an event”
#    And I fill in the fields with:
#      | name                       | datetime          | aspect                                           |
#      | Town Hall meeting  | noon tomorrow | Government Operation & Politics |
#    And I press “Add event”
#    And I am taken to “/nj/municipality/west-ocean” (my jurisdiction)
#    And I see “Your event has been added to the calendar for West Ocean”
#    And I see “Town Hall meeting” at the top of the events list
