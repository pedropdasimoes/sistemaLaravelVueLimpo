export const toggleStyleMixin = {
    props: {
        colorToggle: {
            type: String,
            default: 'solid-dark'
        }
    },
    data(){
        return {
        }
    },
    computed: {
        calculatedToggleStyle(){
            console.log(this.colorToggle+'oi')
            switch(this.colorToggle){
                case 'solid-light':
                    return '#00a6ff';
                case 'solid-dark':
                    return '#a16eff';
                case 'solid-cosmic':
                    return '#a16';
                default:
                    return '#ffa6ff';
            }
            return '#000'
        },
    }
}