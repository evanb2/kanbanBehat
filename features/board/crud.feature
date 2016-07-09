Feature: Board task crud
    In order to interact with the board
    As a user
    I need to be able to CRUD tasks

    Background: Login and go to my board
        Given I am on "/"
        When I login
        Then I should be on the homepage

        Scenario: Create a task
            Given I am on "/kanban/board"
            When I add a new task
            Then I should see that task
#            When this shit doesn't work and I have to debug

#        Scenario: Delete a task

#        Scenario: Update a task

#        Scenario: Assign task to project

#        Scenario: Assign task to user

#        Scenario: Add title to task

#        Scenario: Edit hours worked on task

#        Scenario: Edit estimate for task