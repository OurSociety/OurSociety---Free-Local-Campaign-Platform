Feature: Homepage
  In order to learn about OurSociety
  As a guest
  The homepage should be informative

  Scenario: The application homepage redirects to blog homepage
    When I try to access the root of the application
    Then I should be redirected to the blog
