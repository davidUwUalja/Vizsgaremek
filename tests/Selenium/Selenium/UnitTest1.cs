using OpenQA.Selenium;
using OpenQA.Selenium.Edge;
using OpenQA.Selenium.Support.UI;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using System;
using System.Collections.ObjectModel;

namespace SeleniumTests
{
    [TestClass]
    public class UserTests
    {
        private IWebDriver driver;
        private WebDriverWait wait;

        [TestInitialize]
        public void SetUp()
        {
            driver = new EdgeDriver();
            driver.Manage().Window.Maximize();
            driver.Navigate().GoToUrl("http://frontend.vm1.test");
            wait = new WebDriverWait(driver, TimeSpan.FromSeconds(10));
        }

        // 1. Regisztráció teszt
        [TestMethod]
        public void CreateUserTest()
        {
            // 1. Várjuk meg, hogy az AuthModal látható legyen.
            IWebElement modalContainer = wait.Until(drv =>
            {
                try
                {
                    var modal = drv.FindElement(By.CssSelector("div.fixed.inset-0"));
                    return modal.Displayed ? modal : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            // 2. Váltás a regisztrációs módra.
            IWebElement toggleButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[class*='text-blue-500'][class*='underline']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            ((IJavaScriptExecutor)driver).ExecuteScript("arguments[0].scrollIntoView(true);", toggleButton);
            toggleButton.Click();

            // 3. Regisztrációs adatok kitöltése
            IWebElement nameInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='text']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            nameInput.SendKeys("Test User");

            IWebElement emailInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='email']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            emailInput.SendKeys("testuser@example.com");

            wait.Until(drv => drv.FindElements(By.CssSelector("input[type='password']")).Count >= 2);
            ReadOnlyCollection<IWebElement> passwordInputs = driver.FindElements(By.CssSelector("input[type='password']"));
            passwordInputs[0].SendKeys("Password123");
            passwordInputs[1].SendKeys("Password123");

            IWebElement submitButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[type='submit']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            submitButton.Click();

            // 4. Sikeres regisztráció üzenet ellenőrzése
            IWebElement successMsgElement = wait.Until(drv =>
            {
                try
                {
                    var element = drv.FindElement(By.ClassName("success-message"));
                    return element.Displayed ? element : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            string successMessage = successMsgElement.Text;
            Assert.AreEqual("Felhasználó sikeresen létrehozva!", successMessage);
        }

        // 2. Kijelentkezés teszt
        [TestMethod]
        public void LogoutTest()
        {
            // Bejelentkezés előtt várjuk meg az AuthModal-t és kattintsunk a login gombra
            IWebElement modalContainer = wait.Until(drv =>
            {
                try
                {
                    var modal = drv.FindElement(By.CssSelector("div.fixed.inset-0"));
                    return modal.Displayed ? modal : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            // Belépéshez toggle gomb kattintás
            IWebElement toggleButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[class*='text-blue-500'][class*='underline']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            ((IJavaScriptExecutor)driver).ExecuteScript("arguments[0].scrollIntoView(true);", toggleButton);
            toggleButton.Click();

            // E-mail és jelszó kitöltése
            IWebElement emailInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='email']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            emailInput.SendKeys("testuser@example.com");

            IWebElement passwordInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='password']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            passwordInput.SendKeys("Password123");

            IWebElement loginButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[type='submit']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            loginButton.Click();

            // Kijelentkezés
            IWebElement logoutButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[class*='logout-button']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            logoutButton.Click();

            // Ellenőrizzük, hogy a kijelentkezés sikerült (pl. a login oldal jelenik meg).
            IWebElement loginPage = wait.Until(drv =>
            {
                try
                {
                    var page = drv.FindElement(By.CssSelector("div.login-page"));
                    return page.Displayed ? page : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            Assert.IsTrue(loginPage.Displayed);
        }

        // 3. Bejelentkezés teszt
        [TestMethod]
        public void LoginTest()
        {
            // 1. Várjuk meg, hogy az AuthModal látható legyen.
            IWebElement modalContainer = wait.Until(drv =>
            {
                try
                {
                    var modal = drv.FindElement(By.CssSelector("div.fixed.inset-0"));
                    return modal.Displayed ? modal : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            // 2. Kattintsunk a login módra.
            IWebElement toggleButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[class*='text-blue-500'][class*='underline']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            ((IJavaScriptExecutor)driver).ExecuteScript("arguments[0].scrollIntoView(true);", toggleButton);
            toggleButton.Click();

            // 3. E-mail és jelszó megadása a regisztrált felhasználóval
            IWebElement emailInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='email']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            emailInput.SendKeys("testuser@example.com");

            IWebElement passwordInput = wait.Until(drv =>
            {
                try
                {
                    var input = drv.FindElement(By.CssSelector("input[type='password']"));
                    return input.Displayed ? input : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            passwordInput.SendKeys("Password123");

            IWebElement loginButton = wait.Until(drv =>
            {
                try
                {
                    var btn = drv.FindElement(By.CssSelector("button[type='submit']"));
                    return btn.Displayed ? btn : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });
            loginButton.Click();

            // 4. Sikeres bejelentkezés üzenet ellenőrzése
            IWebElement successMsgElement = wait.Until(drv =>
            {
                try
                {
                    var element = drv.FindElement(By.ClassName("success-message"));
                    return element.Displayed ? element : null;
                }
                catch (NoSuchElementException)
                {
                    return null;
                }
            });

            string successMessage = successMsgElement.Text;
            Assert.AreEqual("Bejelentkezés sikeres!", successMessage);
        }

        [TestCleanup]
        public void TearDown()
        {
            driver.Quit();
        }
    }
}
