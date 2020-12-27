window.Vue.mixin({
    methods: {
        asset: function (path) {
            return window.Settings.service.assets + path
        },

        url: function (path) {
            return window.Settings.service.api + path
        },
        updateUrl: function (params) {
            let url = new URL(window.location.href)
            for (const key in params) {
                if (url.searchParams.has(key)) {
                    url.searchParams.delete(key)
                }
                if (params[key] !== null) {
                    url.searchParams.append(key, params[key])
                }
            }
            window.history.pushState({ path: url.href }, '', url.href)
        },
        slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        },
    
        current_date() {
            var date = new Date();
            return date.getFullYear() + '/' + date.getMonth() + '/' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
        },
    
        toTime(seconds) {
            var date = new Date(null);
            date.setSeconds(seconds);
            return date.toISOString().substr(11, 8);
        },
    
        toSeconds(time) {
            let seconds = time.split(':').reverse().reduce((prev, curr, i) => prev + curr * Math.pow(60, i), 0)
    
            return seconds
        },
    
        number_short(count, withAbbr = false, decimals = 2) {
            const COUNT_ABBRS = ['', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];
            const i = 0 === count ? count : Math.floor(Math.log(count) / Math.log(1000));
            let result = parseFloat((count / Math.pow(1000, i)).toFixed(decimals));
            if (withAbbr) {
                result += `${COUNT_ABBRS[i]}`;
            }
            return result;
        },
        set_error (errors, name) {
            return typeof errors[name] != 'undefined' ? errors[name] : [];
        },

        time () {
            let timestamp = Math.floor(new Date().getTime() / 1000)
            return timestamp;
        },

        limitWords(text, number) {
            let data = text.split(' ');
            let data_string = '';
            for (var  i = 0; i < number; i++) {
                data_string += data[i] ? data[i] + ' ' : ''
            }
            return data_string.trim();
        },

        env_name() {
            return window.Settings.name
        },
        env_initial() {
            return window.Settings.sigla
        },
        env_description() {
            return window.Settings.description
        },
        env_logo() {
            return window.Settings.logo
        },
        env_delete() {
            return window.Settings.db.delete
        },
        env_forcedelete () {
            return window.Settings.db.forceDelete;
        }
    }
})