using Microsoft.VisualStudio.TestTools.UnitTesting;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json;

[TestClass]
public class ProductControllerTests
{
    private static readonly HttpClient client = new HttpClient { BaseAddress = new System.Uri("http:/backend.vm1.test/api/") };

    [TestMethod]
    public async Task GetProductById_ReturnsProduct()
    {
        var response = await client.GetAsync("products/1");
        Assert.IsTrue(response.IsSuccessStatusCode, "A termék lekérdezése sikertelen.");

        var responseBody = await response.Content.ReadAsStringAsync();
        var product = JsonConvert.DeserializeObject<dynamic>(responseBody);

        Assert.IsNotNull(product);
    }

}
