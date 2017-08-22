#@citizen @questions @values
#Feature: Citizens can answers questions
#    In order to compare societal values
#    As a citizen
#    I want to answer questions about societal aspects
#
#    @navigation
#    Scenario: Citizens see 10 random questions by default.
#        When I log in as "John Doe"
#        Then I am on "/citizen/questions"
#        And  I should see the heading "Societal Values"
#        And  I should see "10" random questions
#
#    @visual
#    Scenario: Citizens see 10 random questions by default.
#        When I log in as "John Doe"
#        Then I am on "/citizen/questions"
#        And  I should see the heading "Societal Values"
#        And  I should see "10" random questions
#
##    Scenario: The same random questions are always displayed
##        When I log in as "John Doe"
##        Then I am on "/citizen/questions"
##        And  I should see the heading "Societal Values"
##        And  I should see "10" random questions
##        And  I refresh the page
##        And  I should see the same "10" random questions
##
##    Scenario: The user can shuffle to get different random questions
##        When I log in as "John Doe"
##        Then I am on "/citizen/questions"
##        And  I should see "Societal Values"
##        And  I should see "10" random questions
##        And  I press the shuffle button
##        And  I should see "10" different random questions
##
##    Scenario: The user is alerted if they try to navigate away without saving answers
##        When I log in as "John Doe"
##        Then I am on "/citizen/questions"
##        And  I should see "Societal Values"
##        And  I should see "10" random questions
##        And  I press the shuffle button
##        And  I should see "10" different random questions
#
##    Scenario: Show the article
##        Given I am on "TopPage"
##        When  I follow "A title once again"
##        Then  I should see "And the post body follows."
##
##    Scenario: Add new article
##        Given I am on "TopPage"
##        And   I follow "Add"
##        And   I login "bob" "obo"
##        When  I post article form :
##            | Label      | Value                 |
##            | Categories | Events                |
##            | Title      | Today is Party        |
##            | Body       | From 19:30 with Alice |
##        And   I should see "Your article has been saved."
##        And   I should see "Today is party"
##
##    Scenario: Remove article
##        Given I am on "TopPage"
##        When  I delete article "Title strikes back"
##        Then  I should not see "Title strikes back"
