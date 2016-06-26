<?php


use Behat\Behat\Context\ClosuredContextInterface,
		Behat\Behat\Context\TranslatedContextInterface,
		Behat\Behat\Context\BehatContext,
		Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
		Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
	/**
	 * Initializes context.
	 * Every scenario gets it's own context object.
	 *
	 * @param array $parameters context parameters (set them up through behat.yml)
	 */
	public function __construct()
	{
			// $this->wp_users = $parameters['wp_users'];
	}



	/**
     * Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element
 
        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }
        
        // ok, let's click on it
        $element->click();
 
    }


	/**
     * @when /^(?:|I )confirm the popup$/
     */
    public function confirmPopup()
    {
        $this->getSession()->getDriver()->getWebDriverSession()->accept_alert();
    }


	/**
	 * @Given /^I am logged in as "([^"]*)" with password "([^"]*)"$/
	 */
	public function iAmLoggedInAsWithPassword($username, $password)
	{
			$this->visit('/wp-login.php');
			$this->fillField('user_login', $username);
			$this->fillField('user_pass', $password);
			$this->pressButton('wp-submit');
	}



	// @link http://www.grasmash.com/article/behat-step-i-should-see-css-selector#h[]

	/**
	 * @Then /^I should see the css selector "([^"]*)"$/
	 */
	public function iShouldSeeTheCssSelector($css_selector) {
		$element = $this->getSession()->getPage()->find("css", $css_selector);
		if (empty($element)) {
			throw new \Exception(sprintf("The page '%s' does not contain the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
		}
	}



	/**
	 * @Then /^I should not see the css selector "([^"]*)"$/
	 */
	public function iShouldNotSeeAElementWithCssSelector($css_selector) {
		$element = $this->getSession()->getPage()->find("css", $css_selector);
		if (empty($element)) {
			throw new \Exception(sprintf("The page '%s' contains the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
		}
	}


	/**
	*
	* @When /^(?:|I )click the element with CSS selector "([^"]*)"$/
	*/
	public function iClickTheElementWithCssSelector($css_selector)
	{
		$element = $this->getSession()->getPage()->find("css", $css_selector);
		if (empty($element))
		{
			throw new \Exception(sprintf("The page '%s' does not contain the css selector '%s'", $this->getSession()->getCurrentUrl(), $css_selector));
		}
		$element->click();
	}



	/**
	 * @Given /^I hover over the element "([^"]*)"$/
	 */
	public function iHoverOverTheElement($selector)
	{
		$session = $this->getSession(); // get the mink session
		$element = $session->getPage()->find('css', $selector); // runs the actual query and returns the element

		// errors must not pass silently
		if (null === $element) {
				throw new \InvalidArgumentException(sprintf('Could not evaluate CSS selector: "%s"', $selector));
		}

		// ok, let's hover it
		$element->mouseOver();
	}



	/**
	 * @Then /^I wait for the ajax response$/
	 */
	public function iWaitForTheAjaxResponse()
	{
	    $this->getSession()->wait(5000, '(0 === jQuery.active)');
	}



	/**
	* Pauses the scenario until the user presses a key. Useful when debugging a scenario.
	*
	* @Then /^(?:|I )break$/
	*/
	public function iPutABreakpoint()
	{
		fwrite(STDOUT, "\033[s \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
		while (fgets(STDIN, 1024) == '') {}
		fwrite(STDOUT, "\033[u");
		return;
	}

}