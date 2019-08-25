const getApiUrl = () => process.env.VUE_APP_API_URL;
const getGoogleMapsApiKey = () => process.env.GOOGLE_MAPS_API_KEY;
const getPusherApiKey = () => process.env.PUSHER_APP_KEY;
const getPusherCluster = () => process.env.PUSHER_CLUSTER;
const getPusherAppAuthEndpoint = () => process.env.PUSHER_APP_AUTH_ENDPOINT;

export default {
  getApiUrl,
  getGoogleMapsApiKey,
  getPusherApiKey,
  getPusherCluster,
  getPusherAppAuthEndpoint

};
