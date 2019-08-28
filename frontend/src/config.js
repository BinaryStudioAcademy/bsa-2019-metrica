const getApiUrl = () => process.env.VUE_APP_API_URL;
const getGoogleMapsApiKey = () => process.env.VUE_APP_GOOGLE_MAPS_API_KEY;
const getPusherApiKey = () => process.env.VUE_APP_PUSHER_KEY;
const getPusherCluster = () => process.env.VUE_APP_PUSHER_CLUSTER;
const getPusherAppAuthEndpoint = () => process.env.VUE_APP_PUSHER_AUTH_ENDPOINT;

export default {
  getApiUrl,
  getGoogleMapsApiKey,
  getPusherApiKey,
  getPusherCluster,
  getPusherAppAuthEndpoint

};
