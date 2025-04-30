using Microsoft.VisualStudio.TestTools.UnitTesting;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using OpenQA.Selenium.Support.UI;
using System;

namespace BlogDetailsPage
{
    [TestClass]
    public class BlogDetailsPageTests
    {
        private IWebDriver driver;
        private WebDriverWait wait;

        [TestInitialize]
        public void Setup()
        {
            driver = new ChromeDriver();
            driver.Manage().Window.Maximize();
            driver.Navigate().GoToUrl("http://frontend.vm1.test/blogDetailsPage");
            driver.Manage().Timeouts().ImplicitWait = TimeSpan.FromSeconds(10);
            wait = new WebDriverWait(driver, TimeSpan.FromSeconds(20));
        }

        [TestMethod]
        public void TestHeadlineIsVisible()
        {
            var headline = driver.FindElement(By.XPath("//h1[contains(text(),'Kazah Kézműves Hagyományok')]"));
            Assert.IsTrue(headline.Displayed, "The headline should be visible.");
        }

        [TestMethod]
        public void TestImagesAreDisplayed()
        {
            var image1 = driver.FindElement(By.XPath("//img[@alt='Kazah kézműves hagyományok']"));
            var image2 = driver.FindElement(By.XPath("//img[@alt='Kazah kézműves termékek']"));

            Assert.IsTrue(image1.Displayed, "The first image should be visible.");
            Assert.IsTrue(image2.Displayed, "The second image should be visible.");
        }

        [TestMethod]
        public void TestBackToBlogButtonNavigation()
        {
            var backButton = driver.FindElement(By.XPath("//a[contains(text(),'Vissza a Bloghoz')]"));
            backButton.Click();

            wait.Until(d => d.Url.Contains("/blogPage"));
            Assert.IsTrue(driver.Url.Contains("/blogPage"), "The 'Back to Blog' button should navigate to the blog page.");
        }

        [TestCleanup]
        public void Teardown()
        {
            driver.Quit();
        }
    }
}