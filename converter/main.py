# dat ディレクトリ以下のファイルを読み込んで、ファイル名を表示する
import os
import glob
import json
import nkf
from datetime import datetime
import pytz
import base64
import mimetypes


def unix_to_iso8601(unix_time):
    # UNIX時間をdatetimeオブジェクトに変換
    dt = datetime.fromtimestamp(int(unix_time), pytz.utc)
    # タイムゾーンをAsia/Tokyoに変換
    tokyo_tz = pytz.timezone("Asia/Tokyo")
    dt_tokyo = dt.astimezone(tokyo_tz)
    # ISO8601形式の文字列に変換
    return dt_tokyo.isoformat()


def image_to_data_uri(image_str):
    image_path = image_str.split(",")[0]
    mime_type, _ = mimetypes.guess_type(image_path)
    try:
        with open(image_path, "rb") as image_file:
            base64_string = base64.b64encode(image_file.read()).decode("utf-8")
        return f"data:{mime_type};base64,{base64_string}"
    except Exception:
        return None


threads = sorted(glob.glob("dat/*"))
for thread_path in threads:
    thread = os.path.basename(thread_path)
    res_dirs = sorted(glob.glob(f"dat/{thread}/*"))
    for res_dir_path in res_dirs:
        res_dir = os.path.basename(res_dir_path)
        reses = sorted(glob.glob(f"dat/{thread}/{res_dir}/*"))

        res_data = {}
        for res_path in reses:
            res = os.path.basename(res_path)
            if os.path.isdir(f"dat/{thread}/{res_dir}/{res}"):
                continue

            with open(f"dat/{thread}/{res_dir}/{res}", "br") as f:
                file_data = f.read()
            # nkf で file の文字コードを判定する
            output = (
                nkf.nkf("-Sw", file_data).replace(b"<br>", b"\\n").splitlines()
            )
            output = [line.decode("utf-8") for line in output]

            images = list(
                filter(
                    None, [image_to_data_uri(image) for image in output[3:]]
                )
            )

            if res_dir == res:
                # レスの場合にはファイルを作成する
                res_data = {
                    "title": output[0],
                    "password": output[1],
                    "content": output[2],
                    "created_at": unix_to_iso8601(res),
                    "updated_at": unix_to_iso8601(res),
                    "comments": [],
                    "images": images,
                }
            else:
                # コメントの場合には comments に追加する
                comment = {
                    "password": output[1],
                    "content": output[2],
                    "created_at": unix_to_iso8601(res),
                }
                res_data["comments"].append(comment)

        # yaml ファイル名で output を保存する
        with open(f"dat/{thread}/{res_dir}.json", "w") as f:
            json.dump(res_data, f, ensure_ascii=False, indent=2)
