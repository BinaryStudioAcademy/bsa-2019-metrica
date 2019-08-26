const getApiUrl = () => process.env.VUE_APP_API_URL;
const getGoogleMapsApiKey = () => process.env.GOOGLE_MAPS_API_KEY;

export default {
  getApiUrl,
    getGoogleMapsApiKey
};