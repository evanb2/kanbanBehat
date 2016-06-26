Feature: Board task crud
	In order to interact with the board
	As a user
	I need to be able to CRUD tasks

	@javascript
	Scenario: As a user I can add a task
		Given I am logged in as "corey" with password "password"
			And I am on "/kanban/board"
		When I hover over the element "#status-3-tasks"
			And I click the element with CSS selector "#status-3 .btn-new-task"
			And I wait for the ajax response
			And I fill in the following "bob"
		Then I break
