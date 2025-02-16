using OpenQA.Selenium;
using OpenQA.Selenium.Edge;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace SeleniumTests
{
    [TestClass]
    public class UserTests
    {
        IWebDriver driver;

        // A teszt elõtt végrehajtandó inicializálás
        [TestInitialize]
        public void SetUp()
        {
            // EdgeDriver beállítása (Chromium alapú Edge)
            var options = new EdgeOptions(); // Edge böngészõ beállítások
            var driverService = EdgeDriverService.CreateDefaultService(); // WebDriver szolgáltatás
            driver = new EdgeDriver(driverService, options);  // EdgeDriver automatikusan Chromiumot használ
            driver.Manage().Window.Maximize();  // A böngészõ maximalizálása
        }

        // Tesztelés: Felhasználó létrehozása
        [TestMethod]
        public void CreateUserTest()
        {
            // Navigálás a regisztrációs oldalra
            driver.Navigate().GoToUrl("http://backend.vm1.test/register");

            // Ûrlap kitöltése
            driver.FindElement(By.Name("name")).SendKeys("Test User");
            driver.FindElement(By.Name("email")).SendKeys("testuser@example.com");
            driver.FindElement(By.Name("password")).SendKeys("Password123");
            driver.FindElement(By.Name("password_confirmation")).SendKeys("Password123");

            // Felhasználó létrehozása
            driver.FindElement(By.CssSelector("button[type='submit']")).Click();

            // Ellenõrizzük, hogy a sikeres regisztrációs üzenet megjelent-e
            var successMessage = driver.FindElement(By.ClassName("success-message")).Text;
            Assert.AreEqual("Felhasználó sikeresen létrehozva!", successMessage);
        }

        // Teszt után végrehajtandó tisztítás
        [TestCleanup]
        public void TearDown()
        {
            driver.Quit(); // Böngészõ bezárása
        }
    }
}
