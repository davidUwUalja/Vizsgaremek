using Microsoft.VisualStudio.TestTools.UnitTesting;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using OpenQA.Selenium.Support.UI;
using System;

namespace BlogPage
{
    [TestClass]
    public class BlogPageTests
    {
        private IWebDriver driver;
        private WebDriverWait wait;

        [TestInitialize]
        public void Setup()
        {
            driver = new ChromeDriver();
            driver.Manage().Window.Maximize();
            driver.Navigate().GoToUrl("http://frontend.vm1.test/blogPage");
            driver.Manage().Timeouts().ImplicitWait = TimeSpan.FromSeconds(10);
            wait = new WebDriverWait(driver, TimeSpan.FromSeconds(20));
        }

        [TestMethod]
        public void TestBlogHeaderIsVisible()
        {
            var header = driver.FindElement(By.XPath("//h1[contains(text(),'Blog')]"));
            Assert.IsTrue(header.Displayed, "The main blog header should be visible.");
        }

        [TestMethod]
        public void TestBlogSectionsExist()
        {
            var blogSections = driver.FindElements(By.CssSelector(".space-y-10 > div"));
            Assert.IsTrue(blogSections.Count >= 2, "There should be at least 2 blog posts on the blog page.");
        }

        [TestMethod]
        public void TestCommentFormSubmission()
        {
            var nameInput = driver.FindElement(By.Id("name"));
            var messageInput = driver.FindElement(By.Id("message"));
            var submitButton = driver.FindElement(By.XPath("//button[contains(text(),'K�ld�s')]"));

            nameInput.SendKeys("Teszt Elek");
            messageInput.SendKeys("Ez egy automata teszt �zenet.");
            submitButton.Click();

            wait.Until(d =>
                d.FindElement(By.CssSelector(".h-64")).Text.Contains("Teszt Elek") &&
                d.FindElement(By.CssSelector(".h-64")).Text.Contains("Ez egy automata teszt �zenet.")
            );

            Assert.IsTrue(driver.PageSource.Contains("Teszt Elek"), "Comment name should appear after submission.");
            Assert.IsTrue(driver.PageSource.Contains("Ez egy automata teszt �zenet."), "Comment message should appear after submission.");
        }

        [TestCleanup]
        public void Teardown()
        {
            driver.Quit();
        }
    }
}
