<template>
  <v-row cols="15" justify="center" align-content="center" style="height: 80vh">
    <v-col cols="10">
      <template v-if="pageState == CREATE_STATE.INPUT">
        <v-text-field
          v-model="authPass"
          label="認証するパスワードを入力下さい。"
        ></v-text-field>
        <v-btn outlined large @click="auth()" color="indigo">認証</v-btn>
      </template>
      <template v-else-if="pageState == CREATE_STATE.LOADING">
        <div class="text-center">
          <v-progress-circular
            size="96"
            indeterminate
            color="gray darken-1"
          ></v-progress-circular>
          <div class="display-1 mt-10">ロード中</div>
        </div>
      </template>
      <template v-else-if="pageState == CREATE_STATE.SUCCESS">
        <v-row v-if="modeState == MODE.DELETE">
          <v-dialog :value="true" transition="dialog-bottom-transition" max-width="600">
            <v-card>
              <v-toolbar color="success">削除</v-toolbar>
              <v-card-text>
                <div class="text-h4 pa-12">本当に削除しますか</div>
                <div class="body-1 ml-12">file_id: {{ fileId }}</div>
              </v-card-text>
              <v-card-actions class="justify-end">
                <v-btn text @click="deleteWork(fileId)">YES</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
        <template v-else>
          <div class="d-flex">
            <v-text-field
              class="mr-5"
              v-model="form.title"
              label="タイトル"
            ></v-text-field>
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
              <Reader style="height: 175px; overflow-y: scroll" :md="form.md" />
            </v-col>
          </v-row>
          <v-btn
            @click="
              modeState == MODE.CREATE
                ? create()
                : modeState == MODE.EDIT
                ? edit(fileId)
                : null
            "
            outlined
            large
            color="indigo"
            :disabled="
              modeState == MODE.CREATE ? false : modeState == MODE.EDIT ? false : true
            "
            >{{
              modeState == MODE.CREATE ? "作成" : modeState == MODE.EDIT ? "編集" : "None"
            }}</v-btn
          >
        </template>
      </template>
      <v-dialog
        :value="pageState == CREATE_STATE.ERROR"
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
      <template v-if="isCreated">
        <v-snackbar v-if="modeState == MODE.CREATE" v-model="isCreated">
          {{ attribute == "blog" ? "ブログ" : "作品" }}を作成しました。
          <template v-slot:action="{ attrs }">
            <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
              Close
            </v-btn>
          </template>
        </v-snackbar>
        <v-snackbar v-else-if="modeState == MODE.DELETE" v-model="isCreated">
          {{ attribute == "blog" ? "ブログ" : "作品" }}を削除しました。
          <template v-slot:action="{ attrs }">
            <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </template>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { $axios } from "~/utils/api";
import { Store } from "vuex";
import Title from "~/components/Title.vue";
import Reader from "~/components/Reader.vue";

enum CREATE_STATE {
  ERROR = 0,
  INPUT = 1,
  LOADING = 2,
  SUCCESS = 3,
  CREATE_SUCCESS = 4,
  DELETE_SUCCESS = 5,
}
enum ERROR_CODE {
  NONE = 0,
  AUTH = 1,
  CREATE = 2,
}
enum MODE {
  NONE = 0,
  CREATE = 1,
  EDIT = 2,
  DELETE = 3,
}

export default {
  props: ["genre", "mode", "fileId"],
  components: {
    Title,
    Reader,
  },
  data(props: { genre: string; mode: string }): any {
    return {
      // 定数
      CREATE_STATE: CREATE_STATE,
      ERROR_CODE: ERROR_CODE,
      MODE: MODE,

      // 状態
      pageState: CREATE_STATE.INPUT as CREATE_STATE,
      errorState: ERROR_CODE.NONE as ERROR_CODE,
      modeState: (props.mode == "create"
        ? MODE.CREATE
        : props.mode == "edit"
        ? MODE.EDIT
        : props.mode == "delete"
        ? MODE.DELETE
        : MODE.NONE) as MODE,

      isCreated: false as boolean,
      authPass: "" as string, // 認証パスワード
      attribute: props.genre as string,

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
      pageState: CREATE_STATE;
      errorState: ERROR_CODE;
    }): void {
      this.pageState = CREATE_STATE.INPUT;
      this.errorState = ERROR_CODE.NONE;
    },

    // 作成
    async create(this: {
      pageState: CREATE_STATE;
      errorState: ERROR_CODE;
      attribute: string;
      form: {
        title: string;
        img: string;
        md: string;
      };
      isCreated: boolean;
      isAuth: Function;
    }): Promise<void> {
      this.pageState = CREATE_STATE.LOADING;
      const param = {
        title: this.form.title,
        img: this.form.img,
        md: this.form.md,
      };
      await $axios
        .$post(`/${this.attribute}/create`, param)
        .then((responce) => {
          this.isCreated = true;
          this.isAuth();
          setTimeout(() => {
            this.isCreated = false;
          }, 3000);
        })
        .catch(() => {
          this.pageState = CREATE_STATE.ERROR;
          this.errorState = ERROR_CODE.CREATE;
        });
    },
    edit(fileId: string): void {},
    // 認証処理
    async auth(this: {
      pageState: CREATE_STATE;
      errorState: ERROR_CODE;
      authPass: string;
    }): Promise<void> {
      const param = {
        authPass: this.authPass,
      };
      this.pageState = CREATE_STATE.LOADING;
      await $axios.$post("/auth", param).then((responce) => {
        if (responce.is_auth) {
          this.pageState = CREATE_STATE.SUCCESS;
        } else {
          this.pageState = CREATE_STATE.ERROR;
          this.errorState = ERROR_CODE.AUTH;
        }
      });
    },
    // 削除
    async deleteWork(
      this: {
        attribute: string;
        isCreated: boolean;
        pageState: CREATE_STATE;
        $router: any;
      },
      fileId: string
    ): Promise<void> {
      const param = {
        fileId: fileId,
      };

      this.pageState = CREATE_STATE.LOADING;
      await $axios
        .$post(`/${this.attribute}/delete`, param)
        .then(() => {
          this.isCreated = true;
          this.pageState = CREATE_STATE.DELETE_SUCCESS;
        })
        .catch(() => {
          this.pageState = CREATE_STATE.ERROR;
        })
        .finally(() => {
          setTimeout(() => {
            this.$router.push(`/${this.attribute}s`);
          }, 3000);
        });
    },

    // 認証しているか
    async isAuth(this: { pageState: CREATE_STATE }): Promise<void> {
      this.pageState = CREATE_STATE.LOADING;
      $axios.$get("/is-auth").then((responce: any) => {
        if (responce.is_auth) {
          this.pageState = CREATE_STATE.SUCCESS;
        } else {
          this.pageState = CREATE_STATE.INPUT;
        }
      });
    },
  },
  async created(this: {
    isAuth: Function;
    $store: Store<any>;
    modeState: MODE;
    attribute: string;
  }): Promise<void> {
    this.isAuth();

    let titleMode = "" as string;
    let titleAttribute = "" as string;
    if (this.modeState == MODE.CREATE) {
      titleMode = "作成";
    } else if (this.modeState == MODE.EDIT) {
      titleMode = "編集";
    } else if (this.modeState == MODE.DELETE) {
      titleMode = "削除";
    } else {
      titleMode = "NONE";
    }

    if (this.attribute == "blog") {
      titleAttribute = "ブログ";
    } else if (this.attribute == "work") {
      titleAttribute = "作品";
    } else {
      titleAttribute = "NONE";
    }
    this.$store.commit("windowState/setTitle", `${titleAttribute}を${titleMode}`);
  },
};
</script>