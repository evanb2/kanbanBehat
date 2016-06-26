Feature: Reset
	In order to do other tests
	As a QA
	I need to reset all data

	@javascript
	Scenario: As an admin, I reset using the reset plugin
		Given I am logged in as "corey" with password "password"
			And I am on "/wp-admin"
		When I click the element with CSS selector "#menu-tools"
			And I click the element with CSS selector "#menu-tools .wp-submenu-wrap li:nth-of-type(5) a"
			And I fill in "wordpress_reset_confirm" with "reset"
			And I press "wordpress_reset_submit"
			And I confirm the popup
			And I click the element with CSS selector ".menu-icon-plugins"
			And I click the element with CSS selector "#kanban-for-wordpress .activate a"
#		Then I break
