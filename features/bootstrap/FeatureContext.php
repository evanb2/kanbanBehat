<?php


use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    public $username;

    public $password;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @internal param array $parameters context parameters (set them up through behat.yml)
     * @internal param $username
     * @internal param $password
     */
    public function __construct()
    {
        //SET LOGIN CREDENTIALS
        //TODO move this into behat.yml context params
        $this->username = 'evanb';
        $this->password = 'test';
    }

    /**
     * @AfterSuite
     */
    public static function teardown()
    {
        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=wordpress', 'root', 'root');
            $tasks = $db->prepare('DELETE FROM wp_kanban_tasks');
            $tasks->execute();
            $taskLogs = $db->prepare('DELETE FROM wp_kanban_log_comments');
            $taskLogs->execute();
        } catch (PDOException $e) {
            print_r('Teardown error: ' . $e);
        }
    }

    /**
     * @Then /^I wait for the page to load$/
     */
    public function iWaitForThePageToLoad()
    {
        $this->getSession()->wait(2000);
    }

    /**
     * @Then /^I wait for the ajax response$/
     */
    public function iWaitForTheAjaxResponse()
    {
        $this->getSession()->wait(5000, '(0 === jQuery.active)');
    }

    /**
     * @When I login
     */
    public function iLogin()
    {
        $page = $this->getSession()->getPage();
        $page->fillField('user_login', $this->username);
        $page->fillField('user_pass', $this->password);
        $page->pressButton('wp-submit');
        $this->iWaitForThePageToLoad();
    }

    /**
     * @When this shit doesn't work and I have to debug
     */
    public function thisShitDoesntWorkAndIHaveToDebug()
    {
        eval(\Psy\sh());
    }

    /////////////////////--------BOARD-------///////////////////////

    /**
     * @When I add a new task
     */
    public function iAddANewTask()
    {
        $page = $this->getSession()->getPage();
        $col = $page->find('css', '#status-3');
        $col->mouseOver();
        $element = $page->findAll('css', '.btn-task-new');
        $element[1]->press();
    }

    /**
     * @Then I should see that task
     */
    public function iShouldSeeThatTask()
    {
        $this->iWaitForTheAjaxResponse();
        $this->assertElementOnPage('.task');
    }

    /////////////////////--------ADMIN-------///////////////////////

    /**
     * @When I edit the hour interval setting
     */
    public function iEditTheHourIntervalSetting()
    {
        $page = $this->getSession()->getPage();
        $page->fillField('hour_increment', '.3');
    }

    /**
     * @When I edit the hide time tracking setting
     */
    public function iEditTheHideTimeTrackingSetting()
    {
        $page = $this->getSession()->getPage();
    }

    /**
     * @When I edit the use default login screen setting
     */
    public function iEditTheUseDefaultLoginScreenSetting()
    {
        throw new PendingException();
    }

    /**
     * @When I save my settings
     */
    public function iSaveMySettings()
    {
        $page = $this->getSession()->getPage();
        $page->pressButton('submit-settings');
    }

    ///////////////////////////-----------OLD---------/////////////////////////////////
//    /**
//     * Click on the element with the provided xpath query
//     *
//     * @When /^I click on the element with xpath "([^"]*)"$/
//     */
//    public function iClickOnTheElementWithXPath($xpath)
//    {
//        $session = $this->getSession(); // get the mink session
//        $element = $session->getPage()->find(
//            'xpath',
//            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
//        ); // runs the actual query and returns the element
//
//        // errors must not pass silently
//        if (NULL === $element) {
//            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
//        }
//
//        // ok, let's click on it
//        $element->click();
//
//    }
//
//
//    /**
//     * @when /^(?:|I )confirm the popup$/
//     */
//    public function confirmPopup()
//    {
//        $this->getSession()->getDriver()->getWebDriverSession()->accept_alert();
//    }
//
//
//    /**
//     * @Given /^I am logged in as "([^"]*)" with password "([^"]*)"$/
//     */
//    public function iAmLoggedInAsWithPassword($username, $password)
//    {
//        $this->visit('/wp-login.php');
//        $this->fillField('user_login', $username);
//        $this->fillField('user_pass', $password);
//        $this->pressButton('wp-submit');
//    }
//
//
//
//    // @link http://www.grasmash.com/article/behat-step-i-should-see-css-selector#h[]
//
//    /**
//     * @Then /^I should see the css selector "([^"]*)"$/
//     */
//    public function iShouldSeeTheCssSelector($css_selector)
//    {
//        $element = $this->getSession()->getPage()->find("css", $css_selector);
//        if (empty($element)) {
//            throw new \Exception(sprintf(
//                "The page '%s' does not contain the css selector '%s'",
//                $this->getSession()->getCurrentUrl(), $css_selector)
//            );
//        }
//    }
//
//
//    /**
//     * @Then /^I should not see the css selector "([^"]*)"$/
//     */
//    public function iShouldNotSeeAElementWithCssSelector($css_selector)
//    {
//        $element = $this->getSession()->getPage()->find("css", $css_selector);
//        if (empty($element)) {
//            throw new \Exception(sprintf(
//                "The page '%s' contains the css selector '%s'",
//                $this->getSession()->getCurrentUrl(), $css_selector)
//            );
//        }
//    }
//
//
//    /**
//     *
//     * @When /^(?:|I )click the element with CSS selector "([^"]*)"$/
//     */
//    public function iClickTheElementWithCssSelector($css_selector)
//    {
//        $element = $this->getSession()->getPage()->find("css", $css_selector);
//        if (empty($element)) {
//            throw new \Exception(sprintf(
//                "The page '%s' does not contain the css selector '%s'",
//                $this->getSession()->getCurrentUrl(), $css_selector)
//            );
//        }
//        $element->click();
//    }
//
//
//    /**
//     * @Given /^I hover over the element "([^"]*)"$/
//     */
//    public function iHoverOverTheElement($selector)
//    {
//        $session = $this->getSession(); // get the mink session
//        $element = $session->getPage()->find('css', $selector); // runs the actual query and returns the element
//
//        // errors must not pass silently
//        if (NULL === $element) {
//            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS selector: "%s"', $selector));
//        }
//
//        // ok, let's hover it
//        $element->mouseOver();
//    }
//
//    /**
//     * Pauses the scenario until the user presses a key. Useful when debugging a scenario.
//     *
//     * @Then /^(?:|I )break$/
//     */
//    public function iPutABreakpoint()
//    {
//        fwrite(STDOUT, "\033[s \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
//        while (fgets(STDIN, 1024) == '') {
//        }
//        fwrite(STDOUT, "\033[u");
//
//        return;
//    }

}