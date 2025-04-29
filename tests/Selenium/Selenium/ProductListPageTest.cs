// ProductListPageTests.cs
using Microsoft.VisualStudio.TestTools.UnitTesting;
using System.Net.Http;
using System.Threading.Tasks;

[TestClass]
public class ProductListPageTests
{
    private static readonly HttpClient client = new HttpClient
    {
        BaseAddress = new System.Uri("http://frontend.vm1.test/")
    };

    [TestMethod]
    public async Task GetProductListPage_ReturnsHtmlWithFilterToggle()
    {
        var response = await client.GetAsync("productList");
        Assert.IsTrue(response.IsSuccessStatusCode, "A terméklista oldal betöltése sikertelen.");

        var html = await response.Content.ReadAsStringAsync();
        Assert.IsTrue(html.Contains("🛠️") && html.Contains("fixed top-28"),
            "A terméklista oldalon nem található a szűrő toggle gomb.");
    }

    [TestMethod]
    public async Task GetProductListPage_ContainsViewDetailsAndAddToCartButtons()
    {
        var response = await client.GetAsync("productList");
        Assert.IsTrue(response.IsSuccessStatusCode, "A terméklista oldal betöltése sikertelen.");

        var html = await response.Content.ReadAsStringAsync();
        Assert.IsTrue(html.Contains("viewDetails") || html.Contains("🔍"),
            "A terméklista oldalon nem található 'Nézet' gomb.");
        Assert.IsTrue(html.Contains("addToCart") || html.Contains("➕"),
            "A terméklista oldalon nem található 'Kosárba' gomb.");
    }
}
