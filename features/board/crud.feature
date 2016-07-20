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
            And I delete that task

        Scenario: Delete a task
            Given I am on "/kanban/board"
            And I add a new task
            Then I should see that task
            When I delete that task
            Then I should not see that task
#            When this shit doesn't work and I have to debug

        Scenario: Add title to task
            Given I am on "/kanban/board"
            And I add a new task
            Then I should see that task
            When I add a title to that task

#        Scenario: Assign task to project
#            Given I am on "/kanban/board"
#            And I add a new task
#            Then I should see that task
#            When I assign a project to that task

#        Scenario: Assign task to user


#        Scenario: Edit hours worked on task

#        Scenario: Edit estimate for task