@politician
Feature: Politician Videos
  In order to promote my views
  As a politician
  I want to embed videos on my profile

  Scenario: Edit video
    Given There is a video
    When I edit that video
    Then The video is updated
