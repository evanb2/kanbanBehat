Feature: General Settings
    In order to
    As a
    I need to be able to

    Background: Login
        Given I am on "/"
        When I login
        Then I should be on the homepage

    Scenario: Access admin settings from my board
        Given I am on "/admin.php?page=kanban_settings"
        When I edit the hour interval setting
#        And I edit the hide time tracking setting
#        And I edit the use default login screen setting
        And I save my settings
        Then I should see "Settings saved"
