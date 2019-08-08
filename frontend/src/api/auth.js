import requestService from "../services/requestService";
import config from "../config";

const resourceUrl = config.getApiUrl() + '/auth';

const authorize = params => requestService.create(resourceUrl + '/login', params);
const me = () => requestService.get(resourceUrl + '/me');

export {
  authorize,
  me
}