
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from webdriver_manager.chrome import ChromeDriverManager
import time

def test_create_user():
    driver = webdriver.Chrome(ChromeDriverManager().install())
    driver.get("http://localhost:3000/register")  # A regisztrációs oldal URL-je

    # Név, email, jelszó, jelszó megerősítése
    driver.find_element(By.ID, "name").send_keys("John Doe")
    driver.find_element(By.ID, "email").send_keys("johndoe@example.com")
    driver.find_element(By.ID, "password").send_keys("Password123")
    driver.find_element(By.ID, "password_confirmation").send_keys("Password123")

    # Regisztrálás gomb megnyomása
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    
    # Várakozás, amíg betöltődnek a válaszok
    time.sleep(2)

    # Ellenőrzés: sikerült-e a regisztráció (pl. sikeres üzenet megjelenése)
    success_message = driver.find_element(By.CLASS_NAME, "success-message").text
    assert "Sikeres regisztráció" in success_message

    driver.quit()


