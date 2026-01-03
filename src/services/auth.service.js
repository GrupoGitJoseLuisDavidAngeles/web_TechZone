export default class AuthService {

    /**
     * 
     * @param {*} identifier 
     * @param {*} password 
     * @param {*} url 
     * @returns {Promise<string>}
     */
    async login(identifier, password, url) {
        let response;
        try {
            response = await fetch(url, {
                method: 'post',
                headers: {
                    'content-type': 'application/json',
                    'accept': 'application/json'
                },
                body: JSON.stringify({ identifier, password })
            });
        } catch (error) {
            throw new Error(error.message);
        }

        let data;

        try {
            data = await response.json();
        } catch (error) {
            throw new Error(error.message);
        }

        if (!data.ok) {
            throw new Error(data.message);
        }

        return data.token;
    }

}