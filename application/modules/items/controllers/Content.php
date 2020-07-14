<?php defined('BASEPATH') || exit('No direct script access allowed');

class Content extends Admin_Controller
{
    /**
     * Basic constructor. Calls the Admin_Controller's constructor, then sets
     * the toolbar title displayed on the admin/content/blog page.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Items_model');

        Template::set('toolbar_title', 'Manage Your Items');
    }

    /**
     * The default page for this context.
     *
     * @return void
     */
    public function index()
    {
        Template::render();
    }


    /**
     * 
     */
    public function getItem()
    {
        $ch = curl_init();
        $payload = 
        array(
            array(
                "operationName" => "PDPInfoQuery",
                "variables" => array(
                    "shopDomain" => "kurniajayaelect",
                    "productKey" => "rumah-fitting-hitam-lampu-baca-arsitek-meja-belajar-model-duduk-jepit"
                ),
                 "query" => "query PDPInfoQuery(\$shopDomain: String, \$productKey: String) {\n  getPDPInfo(productID: 0, shopDomain: \$shopDomain, productKey: \$productKey) {\n    basic {\n      id\n      shopID\n      name\n      alias\n      price\n      priceCurrency\n      lastUpdatePrice\n      description\n      minOrder\n      maxOrder\n      status\n      weight\n      weightUnit\n      condition\n      url\n      sku\n      gtin\n      isKreasiLokal\n      isMustInsurance\n      isEligibleCOD\n      isLeasing\n      catalogID\n      needPrescription\n      __typename\n    }\n    category {\n      id\n      name\n      title\n      breadcrumbURL\n      isAdult\n      detail {\n        id\n        name\n        breadcrumbURL\n        __typename\n      }\n      __typename\n    }\n    pictures {\n      picID\n      fileName\n      filePath\n      description\n      isFromIG\n      width\n      height\n      urlOriginal\n      urlThumbnail\n      url300\n      status\n      __typename\n    }\n    preorder {\n      isActive\n      duration\n      timeUnit\n      __typename\n    }\n    wholesale {\n      minQty\n      price\n      __typename\n    }\n    videos {\n      source\n      url\n      __typename\n    }\n    campaign {\n      campaignID\n      campaignType\n      campaignTypeName\n      originalPrice\n      discountedPrice\n      isAppsOnly\n      isActive\n      percentageAmount\n      stock\n      originalStock\n      startDate\n      endDate\n      endDateUnix\n      appLinks\n      hideGimmick\n      __typename\n    }\n    stats {\n      countView\n      countReview\n      countTalk\n      rating\n      __typename\n    }\n    txStats {\n      txSuccess\n      txReject\n      itemSoldPaymentVerified\n      __typename\n    }\n    cashback {\n      percentage\n      __typename\n    }\n    variant {\n      parentID\n      isVariant\n      __typename\n    }\n    stock {\n      useStock\n      value\n      stockWording\n      __typename\n    }\n    menu {\n      name\n      __typename\n    }\n    __typename\n  }\n}\n"
            )       
        );

        $data = '[{"operationName":"PDPInfoQuery","variables":{"shopDomain":"kurniajayaelect","productKey":"rumah-fitting-hitam-lampu-baca-arsitek-meja-belajar-model-duduk-jepit"},"query":"query PDPInfoQuery($shopDomain: String, $productKey: String) {\n  getPDPInfo(productID: 0, shopDomain: $shopDomain, productKey: $productKey) {\n    basic {\n      id\n      shopID\n      name\n      alias\n      price\n      priceCurrency\n      lastUpdatePrice\n      description\n      minOrder\n      maxOrder\n      status\n      weight\n      weightUnit\n      condition\n      url\n      sku\n      gtin\n      isKreasiLokal\n      isMustInsurance\n      isEligibleCOD\n      isLeasing\n      catalogID\n      needPrescription\n      __typename\n    }\n    category {\n      id\n      name\n      title\n      breadcrumbURL\n      isAdult\n      detail {\n        id\n        name\n        breadcrumbURL\n        __typename\n      }\n      __typename\n    }\n    pictures {\n      picID\n      fileName\n      filePath\n      description\n      isFromIG\n      width\n      height\n      urlOriginal\n      urlThumbnail\n      url300\n      status\n      __typename\n    }\n    preorder {\n      isActive\n      duration\n      timeUnit\n      __typename\n    }\n    wholesale {\n      minQty\n      price\n      __typename\n    }\n    videos {\n      source\n      url\n      __typename\n    }\n    campaign {\n      campaignID\n      campaignType\n      campaignTypeName\n      originalPrice\n      discountedPrice\n      isAppsOnly\n      isActive\n      percentageAmount\n      stock\n      originalStock\n      startDate\n      endDate\n      endDateUnix\n      appLinks\n      hideGimmick\n      __typename\n    }\n    stats {\n      countView\n      countReview\n      countTalk\n      rating\n      __typename\n    }\n    txStats {\n      txSuccess\n      txReject\n      itemSoldPaymentVerified\n      __typename\n    }\n    cashback {\n      percentage\n      __typename\n    }\n    variant {\n      parentID\n      isVariant\n      __typename\n    }\n    stock {\n      useStock\n      value\n      stockWording\n      __typename\n    }\n    menu {\n      name\n      __typename\n    }\n    __typename\n  }\n}\n"}]';

        $headers = array(
            'accept:*/*',
            'accept-encoding:gzip, deflate',
            'accept-language:en-US,en;q=0.9',
            'content-length:2203',
            'content-type:application/json',
            // 'cookie: DID=850fd255c189c0e5b6041b94f2d85c9c907928ad96917cc73db874dfd7d1348d322247f840f1b0c05391536097aede9b; DID_JS=ODUwZmQyNTVjMTg5YzBlNWI2MDQxYjk0ZjJkODVjOWM5MDc5MjhhZDk2OTE3Y2M3M2RiODc0ZGZkN2QxMzQ4ZDMyMjI0N2Y4NDBmMWIwYzA1MzkxNTM2MDk3YWVkZTli47DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU=; _gcl_au=1.1.417507105.1587665870; _ga=GA1.2.495953162.1587665870; __auc=7ec3fcb1171a842aceb44f52318; _fbp=fb.1.1587665875170.782434246; g_yolo_production=1; _hjid=1e6fff54-14b7-467e-8848-3698742410df; _jx=d31aca60-858e-11ea-a35e-471634991872; _jxs=1587665906-d31aca60-858e-11ea-a35e-471634991872; _gcl_aw=GCL.1587665974.CjwKCAjw-YT1BRAFEiwAd2WRtpiNUKyv076yh3Zp-StbzIpCRtd95hodaEdqMuOMpOdN2XHgJMKyLxoCn8oQAvD_BwE; _gcl_dc=GCL.1587665974.CjwKCAjw-YT1BRAFEiwAd2WRtpiNUKyv076yh3Zp-StbzIpCRtd95hodaEdqMuOMpOdN2XHgJMKyLxoCn8oQAvD_BwE; _gac_UA-9801603-1=1.1587665878.CjwKCAjw-YT1BRAFEiwAd2WRtpiNUKyv076yh3Zp-StbzIpCRtd95hodaEdqMuOMpOdN2XHgJMKyLxoCn8oQAvD_BwE; _UUID_NONLOGIN_=69dae9ead20fb652a59b02b1e9fd5904; lang=id; isWebpSupport=true; zarget_visitor_info=%7B%7D; _BID_TOKOPEDIA_=39de2f9592f8b1ab05203c17ae33c5fc; S_L_b1e0836efdf987d2fea0b98d14141e5b=c8eb64cfa8b66f66557740bddfb3c194~20200824032348; _abck=1A725F76D5229BD53E5901448E041292~0~YAAQ1iE1F0kJqEpyAQAA3LjKbQPe3LLqUJAYiw8Y4Z2p0rLB7lMEupBfm6Q5Y+jyO9fpIJp+N2mMYK6vW5ZSPlAi3/PIBXtY5vEgnCQMSFNk0bK/yfKhwOqi39l+m8vq6J/h07b0T80a/kNkWXQ+vGIFi6jBI8FGrV0Xeap2YNZWt9FT74dsFNWvptxrPF+ndd6fKJftFlQOSphWNQ16BLL50BjQ3kv0TlseEL9GRiJ29qfaG1zGNwDX6UIixsmldjbk5CTsNxdiBG+pKgUVrcj+Lz+c4+mJq+SoejVuhG32VqnH0pE6t1O24QqG4aR2wzMgYWrlaTjYaA==~-1~-1~-1; bm_sz=350829D5B2F9204AFF45FB7BEC868163~YAAQf0gcuGtLGxFzAQAAFFIFQQibMWiqogUytz5biA2d8/qs/51smnGNm7mj6kkkUi50WP8ge8UKqRevA2rlMFTXPmFDLHs7tqtWsVWDlbBw/iLHmfVqYH9WHyEFxM9uRfUixIMvz6WebMgQGy4Bg+0q1+ecZ5L8qpjRnjhrU21+hjxEjgh8TBHZ+sWEPrGQVhMU; _SID_Tokopedia_=mhmAE2t4wOKUYEDcHwFbi8lMhK_G_JKT7H4fpsQr8Cmn43HwoV8pW_yyw_e_DtUxIwFWG3P7PUqbRwnYN387fyxij2QGkP_PFuXc-6Qht4yOvP2FantRTIhuDGmCm5IB; ak_bmsc=B71E243A15DB37F0750CF48C0C7BAA19B81C487F6539000056800A5F5FC4B867~plNQdnSeSKL9CvKHO8N9f4geO+UiGJ2E74sIKc1BCBw6Zn5bHoMu9MXYdBk5/iP4q6D5uRt4GmXAeWgiNDcaaRQqpowyKHK1mscEi8Gd5ByOBPH5+/EbxLJ7L8CFzPHE8hX6njWMW6rh/KQVnST2N6x1appgJfnrwMBApXzumdFsdiQrNbv5NsnyjTZSALzJa4lZm2AqCjGAcimPsdZYFjEmfKKMhzpgJK4w8fk7CWeH48iF9T5vMfabKhBHpdRc4+; _gid=GA1.2.1025123509.1594523737; __asc=4e7f7afd17341056c178c61e5f4; moe_uuid=5b013204-db38-46de-8468-bcbd2bf952a2; _gat_UA-9801603-1=1; _dc_gtm_UA-9801603-1=1; bm_sv=6F345DE8EF057A7E9D4147E3F163A9CC~NcyL0OlIm1gsYK++rURNW4iRZMTb7h+1sb0noTK5YOz/dMYlmUsjspjjfKca1YQy1cDXwv70SxMeaoAQc6pT6nqjElzwi0jkF3/lqhVTuuVMGdBPMgsYkGPoyPDnHct/VhfMTZzihKGzh1iDKY4cQ6H5UqppPY/uSZbL+R4OVYk=',
            'origin: https://www.tokopedia.com',
            // 'referer: https://www.tokopedia.com/kurniajayaelect/rumah-fitting-hitam-lampu-baca-arsitek-meja-belajar-model-duduk-jepit',
            'sec-fetch-dest:empty',
            'sec-fetch-mode:cors',
            'sec-fetch-site:same-site',
            'user-agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
            'x-source:tokopedia-lite',
            'x-tkpd-akamai:product_info',
            'x-tkpd-lite-service:zeus',
        );
        
        
        curl_setopt($ch, CURLOPT_URL, "https://gql.tokopedia.com");
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        echo '<pre>';
        print_r($result);
        echo '</pre>';

    }
}