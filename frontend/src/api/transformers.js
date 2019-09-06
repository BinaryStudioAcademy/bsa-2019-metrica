const relateWebsites = (item) => {
    return {
        'id': item.id,
        'title': item.domain  + ' - ' + item.role,
        'value': item.domain
    };
};

export {
    relateWebsites
};
