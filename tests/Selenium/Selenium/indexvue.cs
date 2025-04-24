using Microsoft.VisualStudio.TestTools.UnitTesting;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using OpenQA.Selenium.Support.UI;
using System;

namespace CartCheckout
{
    [TestClass]
    public class LandingPageTests
    {
        private IWebDriver driver;
        private WebDriverWait wait;

        [TestInitialize]
        public void Setup()
        {
            driver = new ChromeDriver();
            driver.Manage().Window.Maximize();
            driver.Navigate().GoToUrl("http://frontend.vm1.test/");
            driver.Manage().Timeouts().ImplicitWait = TimeSpan.FromSeconds(10);
            wait = new WebDriverWait(driver, TimeSpan.FromSeconds(20));
        }

        [TestMethod]
        public void TestLandingPageHeadlineVisible()
        {
            var headline = driver.FindElement(By.XPath("//h1[contains(text(),'Üdvözlünk Webshopunkban!')]"));
            Assert.IsTrue(headline.Displayed, "Headline should be visible on landing page.");
        }

        [TestMethod]
        public void TestVasarlasButtonNavigation()
        {
            var shopButton = driver.FindElement(By.XPath("//a[contains(text(),'Vásárlás')]"));
            shopButton.Click();

            wait.Until(d => d.Url.Contains("/productList"));

            Assert.IsTrue(driver.Url.Contains("/productList"), "Should navigate to /productList page when 'Vásárlás' button is clicked.");
        }

        [TestMethod]
        public void TestBlogButtonNavigation()
        {
            driver.Navigate().GoToUrl("http://frontend.vm1.test/");

            var blogButton = driver.FindElement(By.XPath("//a[contains(text(),'Blog megtekintése')]"));
            blogButton.Click();

            wait.Until(d => d.Url.Contains("/blogpage"));

            Assert.IsTrue(driver.Url.Contains("/blogpage"), "Should navigate to /blogpage when 'Blog megtekintése' button is clicked.");
        }

        [TestMethod]
        public void TestFeatureBoxesAreVisible()
        {
            var features = driver.FindElements(By.CssSelector(".grid .p-6"));
            Assert.AreEqual(3, features.Count, "There should be exactly 3 feature boxes on the landing page.");

            string[] expectedTitles = { "Kézzel készített", "Fenntartható anyagok", "Gyors kiszállítás" };
            for (int i = 0; i < expectedTitles.Length; i++)
            {
                var title = features[i].FindElement(By.TagName("h3")).Text;
                Assert.AreEqual(expectedTitles[i], title, $"Feature box {i + 1} title should be '{expectedTitles[i]}'.");
            }
        }

        [TestCleanup]
        public void Teardown()
        {
            driver.Quit();
        }
    }
}
