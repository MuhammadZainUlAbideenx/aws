<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.live_chat.view_chat") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/live_chat')">{{
                  this.$t("sidebar.live_chat.label")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.live_chat.view_chat") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("sidebar.live_chat.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div v-if="$fetchState.pending">
        <AdminViewLoader />
      </div>
      <div class="container" v-else>
         <div class="form-container">
        <div
          class="
            bg-primary
            rounded-top
            d-flex
            align-items-center
            p-3
            position-relative
          "
        >
          <h4 class="text-white mb-0">{{$t('web.customer.orders.view_page.chat')}}</h4>
          <!-- <button
            type="button"
            class="btn-close position-absolute end-0 top-0 me-2 mt-2"
            @click="closeForm()"
          ></button> -->
        </div>

        <div class="chat-history bg-white py-2" v-chat-scroll>
          <ul
            class="mb-0 list-group list-unstyled"
            v-for="message in messages"
            :key="message.id"
          >
            <li
              v-if="$auth.user.id == message.sender_id"
              class="
                clearfix
                list-style-none
                m-2
                p-2
                px-3
                ms-5
                rounded
                bg-info bg-opacity-10
                text-muted
              "
            >
              <div class="message-data text-end">
                <!-- <span class="message-data-time"
                                      >{{message.created_at}}</span
                                    > -->
              </div>
              <div class="message other-message float-end text-break">
                {{ message.message }}
              </div>
            </li>
            <li
              v-else
              class="
                clearfix
                list-style-none
                m-2
                p-2
                px-3
                me-5
                rounded-pill
                bg-warning bg-opacity-10
                text-muted
              "
            >
              <div class="message-data">
                <!-- <span class="message-data-time"
                                      >{{message.created_at}}</span
                                    > -->
              </div>
              <div class="message my-message text-break">
                {{ message.message }}
              </div>
            </li>
          </ul>
        </div>
        <!-- <label for="msg"><b>Message</b></label> -->
        <div class="position-relative py-2 border-top">
          <input
            type="text"
            placeholder="Type Message..."
            class="form-control"
            @keyup.enter="sendRiderMessage"
            v-model="newMessage"
          />
          <button type="button" v-on:click="sendRiderMessage" class="btn">
            <fa :icon="['fa', 'paper-plane']" />
          </button>
        </div>
      </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script>
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
    meta: {
        permission: "live_chat.index",
        strategy: "read",
    },
  data() {
    return {
    messages: [],
    newMessage: "",
    };
  },
  async fetch() {
    const { data } = await this.$generalService.fetchAdminAllRiderMessages(
      this.$route.params.id
    );
    this.messages = data;
  },
  methods: {
 async sendRiderMessage() {
      if (this.newMessage != "") {
        var message = this.newMessage;
        this.newMessage = "";
        this.messages.push({
          message: message,
          sender_id: this.$auth.user.id,
        });

        var payload = {
          sender_id: this.$auth.user.id,
          receiver_id: this.messages[0].sender_id,
          message: message,
          user_type: "admin",
          order_number: this.messages[0].order_number,
        };

        await this.$webService.sendMessage(payload).then(async (res) => {});
      } else {
        this.$toast.error("Please Type Message");
      }
    },
    async fetchRiderMessages() {
      const params = {
        sender_id: this.$auth.user.id,
        receiver_id: this.messages[0].sender_id,
        user_type: "admin",
        order_number: this.messages[0].order_number,
      };
      const { data } = await this.$webService.fetchMessages(params);
      if (data) {
        this.messages = data;
      }
    },
  },
created() {
    this.$echo.channel(this.$config.PUSHER_APP_CHANNEL_NAME).listen(this.$config.PUSHER_APP_EVENT_NAME, (e) => {
      if (e.message.receiver_id == this.$auth.user.id && e.message.order_number == this.messages[0].order_number ) {
        this.messages.push({
          message: e.message.message,
          receiver_id: e.message.receiver_id,
        });
      }
    });
  },
  computed: {

  },
  mounted() {},
};
</script>
<style scoped>
body {
  font-family: Arial, Helvetica, sans-serif;
}
* {
  box-sizing: border-box;
}

/* Button used to open the chat form - fixed at the bottom of the page */

/* The popup chat - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  z-index: 9;
  border-radius: 0.4rem 0.4rem 0 0;
  box-shadow: 0 0 1rem 0 rgba(0, 0, 0, 0.1);
  background-color: white;
}
.chat-popup .chat-history {
  max-height: 380px;
  overflow: hidden auto;
}

/* Add styles to the form container */

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}
/* Set a style for the submit/send button */
.form-container .btn {
  position: absolute;
  top: 8px;
  right: 8px;
  color: var(--primary);
  font-size: 1.2rem;
}
.form-container .form-control {
  padding-right: 2.5rem;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover,
.open-button:hover {
  opacity: 1;
}

</style>
