const tableTransformerErrors = (item) => {
    return {
        'parameter': item.parameter,
        'parameter_value': item.parameter_value,
        'total': item.total,
        'message': item.message,
        'stack_trace': item.stack_trace,
    };
};

export {
    tableTransformer,
};