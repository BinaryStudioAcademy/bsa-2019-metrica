import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = id => requestService.get(resourceUrl + '/' + id);

const addWebsite = data => requestService.create(resourceUrl, data);

const updateWebsite = (data, id) => requestService.update(resourceUrl + '/' + id, data);

const getRelateUserWebsites = () => requestService.get(resourceUrl + '/relate')
    .then(response => response.data)
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting visits data'
            )
        )
    ));

export {
    getCurrentUserWebsite,
    addWebsite,
    updateWebsite,
    getRelateUserWebsites
};
