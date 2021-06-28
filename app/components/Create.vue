<template>
  <v-row cols="15" justify="center" align-content="center" style="height: 80vh">
    <v-col cols="10">
      <template v-if="authState == CREATE_STATE.INPUT">
        <v-text-field
          v-model="authPass"
          label="認証するパスワードを入力下さい。"
        ></v-text-field>
        <v-btn outlined large @click="auth()" color="indigo">認証</v-btn>
      </template>
      <template v-else-if="authState == CREATE_STATE.LOADING">
        <div class="text-center">
          <v-progress-circular
            size="96"
            indeterminate
            color="gray darken-1"
          ></v-progress-circular>
          <div class="display-1 mt-10">ロード中</div>
        </div>
      </template>
      <template v-else-if="authState == CREATE_STATE.SUCCESS">
        <div class="d-flex">
          <v-text-field class="mr-5" v-model="form.title" label="タイトル"></v-text-field>
          <v-text-field class="ml-5" v-model="form.img" label="イメージ"></v-text-field>
        </div>
        <v-row cols="15" justify="center" align-content="center">
          <v-col cols="6">
            <v-textarea
              v-model="form.md"
              @keydown.tab.prevent="form.md += '\t'"
              label="md"
              no-resize
            >
            </v-textarea>
          </v-col>
          <v-col cols="6">
            <Reader :md="form.md" />
          </v-col>
        </v-row>
        <v-btn @click="create()" outlined large color="indigo">作成</v-btn>
      </template>
      <v-dialog
        :value="authState == CREATE_STATE.ERROR"
        transition="dialog-bottom-transition"
        max-width="600"
      >
        <v-card>
          <v-toolbar color="red">ErrorCode: {{ errorState }}</v-toolbar>
          <v-card-text>
            <div class="text-h4 pa-12">
              <template v-if="errorState == ERROR_CODE.AUTH">認証失敗</template>
              <template v-else-if="errorState == ERROR_CODE.CREATE">作成失敗</template>
            </div>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn text @click="clickCloseErrorWindow()">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-snackbar v-model="isCreated">
        {{ mode == "blog" ? "ブログ" : "作品" }}を作成しました。
        <template v-slot:action="{ attrs }">
          <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { $axios } from "~/utils/api";
import Title from "~/components/Title.vue";
import Reader from "~/components/Reader.vue";

enum CREATE_STATE {
  ERROR = 0,
  INPUT = 1,
  LOADING = 2,
  SUCCESS = 3,
  CREATE_SUCCESS = 4,
}
enum ERROR_CODE {
  NONE = 0,
  AUTH = 1,
  CREATE = 2,
}

export default {
  props: ["genre"],
  components: {
    Title,
    Reader,
  },
  data(props: any): any {
    return {
      // 定数
      CREATE_STATE: CREATE_STATE,
      ERROR_CODE: ERROR_CODE,

      // 状態
      authState: CREATE_STATE.INPUT as CREATE_STATE,
      errorState: ERROR_CODE.NONE as ERROR_CODE,

      isCreated: false as boolean,
      authPass: "" as string, // 認証パスワード
      mode: props.genre as string,

      // フォーム
      form: {
        title: "" as string,
        img: "" as string,
        md: "" as string,
      } as any,
    } as any;
  },
  methods: {
    // エラーwindowを閉じる
    clickCloseErrorWindow(this: {
      authState: CREATE_STATE;
      errorState: ERROR_CODE;
    }): void {
      this.authState = CREATE_STATE.INPUT;
      this.errorState = ERROR_CODE.NONE;
    },

    // 作成
    async create(this: {
      authState: CREATE_STATE;
      errorState: ERROR_CODE;
      mode: string;
      form: {
        title: string;
        img: string;
        md: string;
      };
      isCreated: boolean;
      isAuth: Function;
    }): Promise<void> {
      this.authState = CREATE_STATE.LOADING;
      const param = {
        title: this.form.title,
        img: this.form.img,
        md: this.form.md,
      };
      await $axios
        .$post(`/${this.mode}/create`, param)
        .then((responce) => {
          this.isCreated = true;
          this.isAuth();
          setTimeout(() => {
            this.isCreated = false;
          }, 3000);
        })
        .catch(() => {
          this.authState = CREATE_STATE.ERROR;
          this.errorState = ERROR_CODE.CREATE;
        });
    },

    // 認証処理
    async auth(this: {
      authState: CREATE_STATE;
      errorState: ERROR_CODE;
      authPass: string;
    }): Promise<void> {
      const param = {
        authPass: this.authPass,
      };
      this.authState = CREATE_STATE.LOADING;
      await $axios.$post("/auth", param).then((responce) => {
        if (responce.is_auth) {
          this.authState = CREATE_STATE.SUCCESS;
        } else {
          this.authState = CREATE_STATE.ERROR;
          this.errorState = ERROR_CODE.AUTH;
        }
      });
    },

    // 認証しているか
    async isAuth(this: { authState: CREATE_STATE }): Promise<void> {
      this.authState = CREATE_STATE.LOADING;
      $axios.$get("/is-auth").then((responce: any) => {
        if (responce.is_auth) {
          this.authState = CREATE_STATE.SUCCESS;
        } else {
          this.authState = CREATE_STATE.INPUT;
        }
      });
    },
  },
  async created(this: { isAuth: Function }): Promise<void> {
    this.isAuth();
  },
};
</script>
