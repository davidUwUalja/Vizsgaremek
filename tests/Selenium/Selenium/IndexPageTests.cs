using Microsoft.VisualStudio.TestTools.UnitTesting;
using System.Net.Http;
using System.Threading.Tasks;

[TestClass]
public class IndexPageTests
{
    private static readonly HttpClient client = new HttpClient
    {
        BaseAddress = new System.Uri("http://frontend.vm1.test/")
    };

    [TestMethod]
    public async Task GetIndexPage_ReturnsHtmlWithWelcomeHeader()
    {
        var response = await client.GetAsync("");
        Assert.IsTrue(response.IsSuccessStatusCode, "A főoldal betöltése sikertelen.");

        var html = await response.Content.ReadAsStringAsync();
        Assert.IsTrue(html.Contains("<h1") && html.Contains("text-5xl"), 
            "A főoldalon nem található a várt címsor.");
    }

    [TestMethod]
    public async Task GetIndexPage_ContainsNavigationLinks()
    {
        var response = await client.GetAsync("");
        Assert.IsTrue(response.IsSuccessStatusCode, "A főoldal betöltése sikertelen.");

        var html = await response.Content.ReadAsStringAsync();
        Assert.IsTrue(html.Contains("to=\"/productList\"") || html.Contains("href=\"/productList\""),
            "A 'Vásárlás' gomb nem mutat a /productList oldalra.");
        Assert.IsTrue(html.Contains("to=\"/blogpage\"") || html.Contains("href=\"/blogpage\""),
            "A 'Blog' gomb nem mutat a /blogpage oldalra.");
    }
}
