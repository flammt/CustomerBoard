import axios from "axios";

/**
 * Does all the axios calls
 * new ServiceRequest()
 * sr.url = ...
 * sr.do* ((error, data) => {
 *      error: code
 *     if error data=message
 *     else data=result
 * }
 */
class ServiceRequest {

    /**
     * Quick solution to circumvent a centralized 'request queue'
     */
    logOnce () {
        if(!this.logOnce.log) {
            this.logOnce.log = true;
            axios.interceptors.request.use(request => {
                console.log('Starting Request: ', request);
                return request;
            });
        }
        // use the csrf token from index view
        axios.defaults.headers.common = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    constructor() {
        this.logOnce();
    }

    /**
     * Interrupt running request
     */
    cancel () {
        if (this.cancelSource) {
            this.cancelSource.cancel();
        }
    }

    /**
     * Do an api get request
     * Set: service.url
     * @param callback (error, message)
     */
    doGet (callback) {
        this.cancelSource = axios.CancelToken.source();
        axios.get(this.url, {
            cancelToken: this.cancelSource.token,
            headers: {'Content-Type': 'application/json'}
        }).then(response => this.evaluate(response, callback)).catch(error => {
            console.log('Error: ' + error);
        });
    }

    /**
     * Do an api post request
     * Set: service.url, service.obj
     * @param callback (error, message)
     */
    doPut (callback) {
        this.cancelSource = axios.CancelToken.source();
        axios.put(this.url, this.obj, {
            cancelToken: this.cancelSource.token,
            headers: {'Content-Type': 'application/json'}
        }).then(response => this.evaluate(response, callback)).catch(error => {
            console.log('Error: ' + error);
        });
    }

    /**
     * Do an api post request
     * Set: service.url, service.obj
     * @param callback (error, message)
     */
    doPost (callback) {
        this.cancelSource = axios.CancelToken.source();
        axios.post(this.url, this.obj, {
            cancelToken: this.cancelSource.token,
            headers: {'Content-Type': 'application/json'}
        }).then(response => this.evaluate(response, callback)).catch(error => {
            console.log('Error: ' + error);
        });
    }

    /**
     * Redirect when not authenticated response.
     *
     * @param response
     * @param callback
     */
    evaluate (response, callback) {
        if (response.data.status.code !== 200) {
            if (response.data.status.code === 401) {
                window.location.href = "login";
                callback(true, 'Not authenticated');
                return;
            }
            console.error(response.data.status.message);
            callback(true, response.data.status.message);
            return;
        }
        callback(false, response.data.result);
        this.cancelSource = null;
    }
}

export default ServiceRequest;