<template>
    <div>
        <div v-if="room_name && user_email && user_displayName" class="mt-4 container mx-auto">
            <vue-jitsi-meet
                ref="jitsiRef"
                domain="meet.jit.si"
                :options="jitsiOptions">
            </vue-jitsi-meet>
        </div>
        <loading v-else />
    </div>
</template>

<script>
import { JitsiMeet } from '@mycure/vue-jitsi-meet';
export default {
    name: 'video-room',
    components: {
        VueJitsiMeet: JitsiMeet
    },
    data: () => ({
        loading: false,
        data: {},
        room_name: 'room-conference',
        room_password: '',
        room_domain: 'meet.jit.si',
        user_email: null,
        user_displayName: null
    }),
    created () {
        this.user_email = window.User.email,
        this.user_displayName= window.User.name + ' ' + window.User.lastname
        this.room_name = 'EDULAAV-' + this.$route.params.id
        this.room_password = this.$route.params.id
    },
    computed: {
        jitsiOptions () {
            return {
                roomName: this.room_name,
                userInfo: {
                    email: this.user_email,
                    displayName: this.user_displayName
                },
                configOverwrite: { 
                    startWithAudioMuted: false,
                    prejoinPageEnabled: false
                },
                interfaceConfigOverwrite: { 
                    APP_NAME: 'Edulaav',

                    DEFAULT_BACKGROUND: '#2D3748',
                    DEFAULT_LOCAL_DISPLAY_NAME: 'EDULAAV',
                    DEFAULT_LOGO_URL: 'https://meet.test/logo.png',
                    DEFAULT_REMOTE_DISPLAY_NAME: 'Fellow Jitster',

                    JITSI_WATERMARK_LINK: 'https://edulaav.ulaav.com',

                    CLOSE_PAGE_GUEST_HINT: false,
                    GENERATE_ROOMNAMES_ON_WELCOME_PAGE: false,

                    DISPLAY_WELCOME_PAGE_CONTENT: false,
                    DISPLAY_WELCOME_PAGE_TOOLBAR_ADDITIONAL_CONTENT: false,
                    ENABLE_DIAL_OUT: false,
                    ENABLE_FEEDBACK_ANIMATION: false,

                    MOBILE_APP_PROMO: false,
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_CHROME_EXTENSION_BANNER: false,
                    SHOW_DEEP_LINKING_IMAGE: false,
                    SHOW_POWERED_BY: false,
                    SHOW_PROMOTIONAL_CLOSE_PAGE: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,

                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'profile', 'chat',
                        'videoquality', 'filmstrip',
                        'tileview', 'mute-everyone', 'hangup'
                    ],
                },
                onload: this.onIFrameLoad
            };
        },
    },
    methods: {
        onIFrameLoad () {
            let _username = this.user_displayName
            let _password = this.room_password
            this.$refs.jitsiRef.executeCommand('displayName', _username);
            this.$refs.jitsiRef.executeCommand('password', _password);
            this.$refs.jitsiRef.addEventListener('participantRoleChanged', this.onParticipantRoleChanged);
            this.$refs.jitsiRef.addEventListener('passwordRequired', this.onPasswordRequired);
            this.$refs.jitsiRef.addEventListener('readyToClose', this.onReadyToClose);
        },
        onReadyToClose () {
            this.$router.push({name:'rooms.show',params:{id:this.$route.params.id}})
        } ,
        onParticipantRoleChanged (event) {
            if (event.role === "moderator") {
                this.$refs.jitsiRef.executeCommand('password', this.room_password);
            }
        },
        onPasswordRequired () {
            this.$refs.jitsiRef.executeCommand('password', this.room_password);
        }
    }
}
</script>

<style>
    #jitsiConferenceFrame0 {
        text-align: center;
    }
    iframe {
        min-height: calc(100vh - 100px);
    }
    .watermark {
        display: none!important;
    }
</style>