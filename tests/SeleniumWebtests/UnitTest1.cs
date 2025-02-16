using OpenQA.Selenium;
using OpenQA.Selenium.Edge;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace SeleniumTests
{
    [TestClass]
    public class UserTests
    {
        IWebDriver driver;

        // A teszt el�tt v�grehajtand� inicializ�l�s
        [TestInitialize]
        public void SetUp()
        {
            // EdgeDriver be�ll�t�sa (Chromium alap� Edge)
            var options = new EdgeOptions(); // Edge b�ng�sz� be�ll�t�sok
            var driverService = EdgeDriverService.CreateDefaultService(); // WebDriver szolg�ltat�s
            driver = new EdgeDriver(driverService, options);  // EdgeDriver automatikusan Chromiumot haszn�l
            driver.Manage().Window.Maximize();  // A b�ng�sz� maximaliz�l�sa
        }

        // Tesztel�s: Felhaszn�l� l�trehoz�sa
        [TestMethod]
        public void CreateUserTest()
        {
            // Navig�l�s a regisztr�ci�s oldalra
            driver.Navigate().GoToUrl("http://backend.vm1.test/register");

            // �rlap kit�lt�se
            driver.FindElement(By.Name("name")).SendKeys("Test User");
            driver.FindElement(By.Name("email")).SendKeys("testuser@example.com");
            driver.FindElement(By.Name("password")).SendKeys("Password123");
            driver.FindElement(By.Name("password_confirmation")).SendKeys("Password123");

            // Felhaszn�l� l�trehoz�sa
            driver.FindElement(By.CssSelector("button[type='submit']")).Click();

            // Ellen�rizz�k, hogy a sikeres regisztr�ci�s �zenet megjelent-e
            var successMessage = driver.FindElement(By.ClassName("success-message")).Text;
            Assert.AreEqual("Felhaszn�l� sikeresen l�trehozva!", successMessage);
        }

        // Teszt ut�n v�grehajtand� tiszt�t�s
        [TestCleanup]
        public void TearDown()
        {
            driver.Quit(); // B�ng�sz� bez�r�sa
        }
    }
}
