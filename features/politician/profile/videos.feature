Feature: Politician Videos
  In order to promote my views
  As a politician
  I want to embed videos on my profile

  Scenario: Edit video
    Given I am signed in as "John Doe"
    And I am on my profile
    And there is a video
    When I edit that video
    Then the video is updated
